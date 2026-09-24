<?php

namespace App\Http\Controllers;

use App\Models\BastPemakaianHeader;
use App\Models\BastPengembalianHeader;

class BastVerificationController extends Controller
{
    /**
     * Halaman verifikasi publik keabsahan dokumen BAST Pemakaian.
     */
    public function verifyPemakaian(BastPemakaianHeader $header)
    {
        $header->load(['details.item', 'pihakPertama', 'pihakKedua', 'pembuat']);

        return view('bast.verify-pemakaian', [
            'header' => $header,
            'isFinal' => $header->status_dokumen === 'final',
            'isSignedPihak1' => ! empty($header->ttd_pihak1_url),
            'isSignedPihak2' => ! empty($header->ttd_pihak2_url),
            'details' => $header->details,
        ]);
    }

    /**
     * Halaman verifikasi publik keabsahan dokumen BAST Pengembalian.
     */
    public function verifyPengembalian(BastPengembalianHeader $header)
    {
        $header->load(['details.item', 'pihakMenyerahkan', 'pihakMenerima', 'pembuat']);

        return view('bast.verify-pengembalian', [
            'header' => $header,
            'isFinal' => $header->status_dokumen === 'final',
            'isSignedPihak1' => ! empty($header->ttd_pihak1_url),
            'isSignedPihak2' => ! empty($header->ttd_pihak2_url),
            'details' => $header->details,
        ]);
    }
}
