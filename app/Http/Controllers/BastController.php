<?php

namespace App\Http\Controllers;

use App\Models\BastPemakaianHeader;
use App\Models\BastPengembalianHeader;
use App\Models\ItemTransaction;
use Barryvdh\DomPDF\Facade\Pdf;

class BastController extends Controller
{
    /**
     * Download BAST Peminjaman Single-Item (Modul Lama / Existing).
     */
    public function download(ItemTransaction $transaction)
    {
        $transaction->load('item');

        $pdf = Pdf::loadView('pdf.bast', compact('transaction'))
            ->setPaper('a4', 'portrait');

        $filename = 'BAST_' . ($transaction->item->kode_bmn ?? 'N-A') . '_' . $transaction->tanggal_pinjam->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Download BAST Pemakaian Multi-Item (Modul Baru).
     */
    public function downloadPemakaian(BastPemakaianHeader $header)
    {
        $header->load(['details.item', 'pihakPertama', 'pihakKedua', 'pembuat']);

        $pdf = Pdf::loadView('pdf.bast-pemakaian', compact('header'))
            ->setPaper('a4', 'portrait');

        $safeNomor = str_replace(['/', '\\', ' '], '_', $header->nomor_bast ?? 'DRAFT_' . $header->id);
        $filename = 'BAST_PEMAKAIAN_' . $safeNomor . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Download BAST Pengembalian Multi-Item (Modul Baru).
     */
    public function downloadPengembalian(BastPengembalianHeader $header)
    {
        $header->load(['details.item', 'pihakMenyerahkan', 'pihakMenerima', 'pembuat']);

        $pdf = Pdf::loadView('pdf.bast-pengembalian', compact('header'))
            ->setPaper('a4', 'portrait');

        $safeNomor = str_replace(['/', '\\', ' '], '_', $header->nomor_bast_pengembalian ?? 'DRAFT_' . $header->id);
        $filename = 'BAST_PENGEMBALIAN_' . $safeNomor . '.pdf';

        return $pdf->download($filename);
    }
}