<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemMutasiRuangan;
use App\Models\RefRuangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RuanganService
{
    /**
     * Move an asset to a new room and record the mutation history.
     */
    public function mutasiItem(
        Item $item,
        RefRuangan $ruanganTujuan,
        ?string $alasan = null,
        ?int $userId = null
    ): ItemMutasiRuangan {
        return DB::transaction(function () use ($item, $ruanganTujuan, $alasan, $userId) {
            $asalId = $item->ref_ruangan_id;

            $item->update([
                'ref_ruangan_id' => $ruanganTujuan->id,
                'lokasi_simpan' => $ruanganTujuan->nama_ruangan,
            ]);

            $log = ItemMutasiRuangan::create([
                'item_id' => $item->id,
                'ruangan_asal_id' => $asalId,
                'ruangan_tujuan_id' => $ruanganTujuan->id,
                'user_id' => $userId ?? auth()->id(),
                'tanggal_mutasi' => now(),
                'alasan' => $alasan ?? 'Mutasi / relokasi penempatan ruangan',
            ]);

            AuditService::log('mutasi_ruangan', 'Item', $item->id, [
                'ruangan_asal_id' => $asalId,
                'ruangan_tujuan_id' => $ruanganTujuan->id,
                'alasan' => $alasan,
            ]);

            return $log;
        });
    }

    /**
     * Generate official Daftar Inventaris Ruangan (DIR) PDF document.
     */
    public function generateDirPdf(RefRuangan $ruangan): array
    {
        $ruangan->load(['items' => fn ($q) => $q->orderBy('kode_bmn')]);

        $pdf = Pdf::loadView('pdf.daftar-inventaris-ruangan', compact('ruangan'))
            ->setPaper('a4', 'portrait');

        $safeKode = str_replace(['/', '\\', ' '], '_', $ruangan->kode_ruangan);
        $filename = 'DIR_'.$safeKode.'_'.date('Ymd').'.pdf';

        return [
            'pdf' => $pdf,
            'filename' => $filename,
        ];
    }

    /**
     * Generate SVG QR Code for room door sticker.
     */
    public function generateRoomQr(RefRuangan $ruangan): string
    {
        return QrCode::format('svg')
            ->size(400)
            ->margin(2)
            ->generate($ruangan->qr_url);
    }
}
