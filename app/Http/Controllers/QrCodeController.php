<?php

namespace App\Http\Controllers;

use App\Models\Item;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function download(Item $item)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Hanya Administrator yang memiliki wewenang mengunduh QR Code BMN.');
        }

        $qrContent = url('/scan/'.$item->kode_bmn);

        $qrImage = QrCode::format('svg')
            ->size(400)
            ->margin(2)
            ->generate($qrContent);

        $filename = 'QR_'.$item->kode_bmn.'.svg';

        return response($qrImage)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    public function printSheet()
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403, 'Hanya Administrator yang memiliki wewenang mencetak lembar QR Code.');
        }

        $items = Item::orderBy('kode_bmn')->get()->map(function (Item $item) {
            $qrContent = url('/scan/' . $item->kode_bmn);

            return [
                'item' => $item,
                'qr_svg' => QrCode::format('svg')->size(180)->margin(1)->generate($qrContent),
            ];
        });

        return view('qrcode.print-sheet', compact('items'));
    }
}

