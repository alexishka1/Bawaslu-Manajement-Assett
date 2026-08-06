<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function index()
    {
        return view('scanner');
    }

    public function show($kode_bmn)
    {
        $item = Item::where('kode_bmn', $kode_bmn)->firstOrFail();
        return view('scan', compact('item'));
    }

    public function store(Request $request, $kode_bmn)
    {
        $item = Item::where('kode_bmn', $kode_bmn)->firstOrFail();

        $request->validate([
            'kondisi_aktual' => 'required|in:tersedia,terpakai,servis,rusak,hilang',
            'foto_bukti' => 'required|image|max:5120', // Maks 5MB
            'catatan' => 'nullable|string',
        ]);

        $path = $request->file('foto_bukti')->store('reports', 'public');

        ItemReport::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'kondisi_aktual' => $request->kondisi_aktual,
            'catatan' => $request->catatan,
            'foto_bukti' => $path,
        ]);

        return redirect()->route('scan.show', $kode_bmn)->with('success', 'Laporan berhasil dikirim! Menunggu validasi admin.');
    }
}
