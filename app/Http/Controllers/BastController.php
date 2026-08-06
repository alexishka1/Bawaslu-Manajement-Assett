<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use Barryvdh\DomPDF\Facade\Pdf;

class BastController extends Controller
{
    public function download(ItemTransaction $transaction)
    {
        $transaction->load('item');

        $pdf = Pdf::loadView('pdf.bast', compact('transaction'))
            ->setPaper('a4', 'portrait');

        $filename = 'BAST_' . ($transaction->item->kode_bmn ?? 'N-A') . '_' . $transaction->tanggal_pinjam->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
