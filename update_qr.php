<?php

use App\Models\Item;

foreach (Item::all() as $item) {
    $item->update(['qr_code' => 'http://192.168.1.177:8000/scan/'.$item->kode_bmn]);
}
echo "All items updated.\n";
