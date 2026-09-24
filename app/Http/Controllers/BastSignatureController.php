<?php

namespace App\Http\Controllers;

use App\Models\BastPemakaianHeader;
use App\Models\BastPengembalianHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BastSignatureController extends Controller
{
    /**
     * Halaman antarmuka tanda tangan digital untuk BAST Pemakaian.
     */
    public function showPemakaian(BastPemakaianHeader $header, string $pihak)
    {
        if (! in_array($pihak, ['pihak1', 'pihak2'])) {
            abort(404, 'Pihak tanda tangan tidak valid.');
        }

        $header->load(['details.item', 'pihakPertama', 'pihakKedua']);

        $namaPihak = ($pihak === 'pihak1')
            ? ($header->pihakPertama->nama ?? 'Pejabat Penyerah').' (NIP. '.($header->pihak_pertama_nip ?? '-').')'
            : $header->pihak_kedua_display;

        $peranPihak = ($pihak === 'pihak1')
            ? 'Pihak Pertama (Yang Menyerahkan / Pejabat BMN)'
            : 'Pihak Kedua (Yang Menerima / Pegawai Pemakai)';

        $existingTtd = ($pihak === 'pihak1') ? $header->ttd_pihak1_url : $header->ttd_pihak2_url;

        return view('bast.sign', [
            'type' => 'pemakaian',
            'header' => $header,
            'nomorBast' => $header->nomor_bast ?? 'DRAFT (Belum Terbit)',
            'pihak' => $pihak,
            'namaPihak' => $namaPihak,
            'peranPihak' => $peranPihak,
            'existingTtd' => $existingTtd,
            'items' => $header->details,
            'submitUrl' => route('bast.pemakaian.sign.store', [$header, $pihak]),
            'backUrl' => url('/admin/bast-pemakaian-headers'),
        ]);
    }

    /**
     * Simpan hasil tanda tangan digital BAST Pemakaian.
     */
    public function storePemakaian(Request $request, BastPemakaianHeader $header, string $pihak)
    {
        if (! in_array($pihak, ['pihak1', 'pihak2'])) {
            abort(404, 'Pihak tanda tangan tidak valid.');
        }

        $request->validate([
            'signature' => 'required|string',
        ]);

        $signatureData = $request->input('signature');

        if (! preg_match('/^data:image\/(\w+);base64,/', $signatureData)) {
            return back()->with('error', 'Format tanda tangan digital tidak valid.');
        }

        $imageData = base64_decode(substr($signatureData, strpos($signatureData, ',') + 1));

        $filename = 'ttd_bast_pemakaian_'.$header->id.'_'.$pihak.'_'.time().'.png';
        Storage::disk('public')->put('signatures/'.$filename, $imageData);
        $publicUrl = '/storage/signatures/'.$filename;

        $field = ($pihak === 'pihak1') ? 'ttd_pihak1_url' : 'ttd_pihak2_url';
        $header->update([$field => $publicUrl]);

        // Jika kedua pihak telah tanda tangan dan masih draft, otomatis finalisasi dokumen
        $header->refresh();
        if ($header->ttd_pihak1_url && $header->ttd_pihak2_url && $header->status_dokumen === 'draft') {
            $header->update(['status_dokumen' => 'final']);
        }

        return redirect()->route('bast.pemakaian.sign', [$header, $pihak])
            ->with('success', 'Tanda tangan digital berhasil disimpan ke dalam dokumen BAST.');
    }

    /**
     * Halaman antarmuka tanda tangan digital untuk BAST Pengembalian.
     */
    public function showPengembalian(BastPengembalianHeader $header, string $pihak)
    {
        if (! in_array($pihak, ['pihak1', 'pihak2'])) {
            abort(404, 'Pihak tanda tangan tidak valid.');
        }

        $header->load(['details.item', 'pihakMenyerahkan', 'pihakMenerima']);

        $namaPihak = ($pihak === 'pihak1')
            ? $header->pihak_menyerahkan_display
            : ($header->pihakMenerima->nama ?? 'Pejabat Penerima').' (NIP. '.($header->pihak_menerima_nip ?? '-').')';

        $peranPihak = ($pihak === 'pihak1')
            ? 'Pihak Pertama (Yang Menyerahkan Kembali / Pegawai)'
            : 'Pihak Kedua (Yang Menerima / Pejabat BMN)';

        $existingTtd = ($pihak === 'pihak1') ? $header->ttd_pihak1_url : $header->ttd_pihak2_url;

        return view('bast.sign', [
            'type' => 'pengembalian',
            'header' => $header,
            'nomorBast' => $header->nomor_bast_pengembalian ?? 'DRAFT (Belum Terbit)',
            'pihak' => $pihak,
            'namaPihak' => $namaPihak,
            'peranPihak' => $peranPihak,
            'existingTtd' => $existingTtd,
            'items' => $header->details,
            'submitUrl' => route('bast.pengembalian.sign.store', [$header, $pihak]),
            'backUrl' => url('/admin/bast-pengembalian-headers'),
        ]);
    }

    /**
     * Simpan hasil tanda tangan digital BAST Pengembalian.
     */
    public function storePengembalian(Request $request, BastPengembalianHeader $header, string $pihak)
    {
        if (! in_array($pihak, ['pihak1', 'pihak2'])) {
            abort(404, 'Pihak tanda tangan tidak valid.');
        }

        $request->validate([
            'signature' => 'required|string',
        ]);

        $signatureData = $request->input('signature');

        if (! preg_match('/^data:image\/(\w+);base64,/', $signatureData)) {
            return back()->with('error', 'Format tanda tangan digital tidak valid.');
        }

        $imageData = base64_decode(substr($signatureData, strpos($signatureData, ',') + 1));

        $filename = 'ttd_bast_kembali_'.$header->id.'_'.$pihak.'_'.time().'.png';
        Storage::disk('public')->put('signatures/'.$filename, $imageData);
        $publicUrl = '/storage/signatures/'.$filename;

        $field = ($pihak === 'pihak1') ? 'ttd_pihak1_url' : 'ttd_pihak2_url';
        $header->update([$field => $publicUrl]);

        // Jika kedua pihak telah tanda tangan dan masih draft, otomatis finalisasi dokumen
        $header->refresh();
        if ($header->ttd_pihak1_url && $header->ttd_pihak2_url && $header->status_dokumen === 'draft') {
            $header->update(['status_dokumen' => 'final']);
        }

        return redirect()->route('bast.pengembalian.sign', [$header, $pihak])
            ->with('success', 'Tanda tangan digital berhasil disimpan ke dalam dokumen BAST Pengembalian.');
    }
}
