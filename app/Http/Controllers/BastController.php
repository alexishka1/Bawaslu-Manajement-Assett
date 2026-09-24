<?php

namespace App\Http\Controllers;

use App\Models\BastPemakaianHeader;
use App\Models\BastPengembalianHeader;
use App\Models\ItemTransaction;
use App\Services\BastService;
use Illuminate\Support\Facades\Gate;

class BastController extends Controller
{
    public function __construct(
        protected BastService $bastService
    ) {}

    /**
     * Download BAST Peminjaman Single-Item (Modul Lama / Existing).
     */
    public function download(ItemTransaction $transaction)
    {
        Gate::authorize('view', $transaction);

        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Hanya Administrator yang memiliki wewenang untuk mengunduh dokumen resmi BAST.');
        }

        $result = $this->bastService->generateSingleBastPdf($transaction);

        return $result['pdf']->download($result['filename']);
    }

    /**
     * Download BAST Pemakaian Multi-Item (Modul Baru).
     */
    public function downloadPemakaian(BastPemakaianHeader $header)
    {
        Gate::authorize('view', $header);

        $result = $this->bastService->generatePemakaianPdf($header);

        return $result['pdf']->download($result['filename']);
    }

    /**
     * Download BAST Pengembalian Multi-Item (Modul Baru).
     */
    public function downloadPengembalian(BastPengembalianHeader $header)
    {
        Gate::authorize('view', $header);

        $result = $this->bastService->generatePengembalianPdf($header);

        return $result['pdf']->download($result['filename']);
    }
}
