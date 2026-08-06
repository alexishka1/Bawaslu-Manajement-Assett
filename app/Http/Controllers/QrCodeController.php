<?php

namespace App\Http\Controllers;

use App\Models\Item;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function download(Item $item)
    {
        $qrContent = url('/scan/' . $item->kode_bmn);

        $qrImage = QrCode::format('svg')
            ->size(400)
            ->margin(2)
            ->generate($qrContent);

        $filename = 'QR_' . $item->kode_bmn . '.svg';

        return response($qrImage)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
