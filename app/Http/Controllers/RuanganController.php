<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\RefRuangan;
use App\Services\RuanganService;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function __construct(
        protected RuanganService $ruanganService
    ) {}

    /**
     * Display live room inventory when room door QR code is scanned.
     */
    public function show(string $kode_ruangan)
    {
        $ruangan = RefRuangan::where('kode_ruangan', $kode_ruangan)
            ->with(['items' => fn ($q) => $q->latest()])
            ->firstOrFail();

        return view('ruangan.show', compact('ruangan'));
    }

    /**
     * Fast relocation: move an item into this room.
     */
    public function pindahBarang(Request $request, string $kode_ruangan)
    {
        $ruangan = RefRuangan::where('kode_ruangan', $kode_ruangan)->firstOrFail();

        $request->validate([
            'kode_bmn' => ['required', 'string'],
            'alasan' => ['nullable', 'string', 'max:255'],
        ]);

        $item = Item::where('kode_bmn', strtoupper(trim($request->kode_bmn)))->first();

        if (! $item) {
            return redirect()
                ->route('ruangan.show', $ruangan->kode_ruangan)
                ->with('error', "Barang dengan kode BMN '{$request->kode_bmn}' tidak ditemukan.");
        }

        $this->ruanganService->mutasiItem(
            item: $item,
            ruanganTujuan: $ruangan,
            alasan: $request->alasan,
            userId: auth()->id()
        );

        return redirect()
            ->route('ruangan.show', $ruangan->kode_ruangan)
            ->with('success', "Aset {$item->nama_barang} ({$item->kode_bmn}) berhasil ditempatkan di {$ruangan->nama_ruangan}!");
    }

    /**
     * Download official Daftar Inventaris Ruangan (DIR) PDF.
     */
    public function downloadDir(RefRuangan $ruangan)
    {
        $result = $this->ruanganService->generateDirPdf($ruangan);

        return $result['pdf']->download($result['filename']);
    }

    /**
     * Download Room QR Code SVG sticker for door tagging.
     */
    public function downloadQr(RefRuangan $ruangan)
    {
        $qrSvg = $this->ruanganService->generateRoomQr($ruangan);
        $filename = 'QR_RUANGAN_'.str_replace(['/', '\\', ' '], '_', $ruangan->kode_ruangan).'.svg';

        return response($qrSvg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
