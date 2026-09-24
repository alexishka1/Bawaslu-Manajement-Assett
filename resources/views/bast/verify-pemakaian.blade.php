<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen BAST Pemakaian - BAWASLU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800 pb-12">

    <!-- Header Instansi -->
    <header class="bg-gradient-to-r from-red-700 via-red-800 to-red-900 text-white shadow-lg">
        <div class="max-w-3xl mx-auto px-4 py-5 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-white/10 mb-2 border border-white/20">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h1 class="text-lg sm:text-xl font-extrabold uppercase tracking-wide">Badan Pengawas Pemilihan Umum</h1>
            <p class="text-xs text-red-200 mt-0.5">Portal Verifikasi Keabsahan Dokumen Elektronik BMN</p>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 -mt-4 space-y-5">

        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200/80 p-6 text-center">
            @if($isFinal)
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-extrabold uppercase tracking-wider rounded-full mb-1">
                    ✓ Dokumen Sah & Terverifikasi
                </span>
                <h2 class="text-xl font-extrabold text-slate-900 mt-1">Berita Acara Serah Terima (BAST)</h2>
                <p class="text-xs text-slate-500 max-w-md mx-auto mt-1">
                    Dokumen ini terdaftar resmi dan telah ditandatangani secara digital dalam Sistem Informasi Manajemen Aset Bawaslu.
                </p>
            @else
                <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-3 shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-xs font-extrabold uppercase tracking-wider rounded-full mb-1">
                    Status: Dokumen Draft
                </span>
                <h2 class="text-xl font-extrabold text-slate-900 mt-1">Berita Acara Serah Terima (BAST)</h2>
                <p class="text-xs text-slate-500 max-w-md mx-auto mt-1">
                    Dokumen ini sedang dalam proses administrasi dan belum diterbitkan secara final.
                </p>
            @endif
        </div>

        <!-- Detail Dokumen -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 space-y-4">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Berita Acara</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-xs text-slate-500 block">Nomor BAST:</span>
                    <span class="font-mono font-bold text-slate-900 text-base">{{ $header->nomor_bast ?? 'DRAFT' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Jenis Dokumen:</span>
                    <span class="font-semibold text-slate-800">
                        {{ match($header->jenis_bast) {
                            'BAST_PEMAKAIAN_KIB' => 'Pemakaian BMN (KIB)',
                            'BAST_PEMAKAIAN_NON_KIB' => 'Pemakaian BMN (Non-KIB)',
                            'BAST_PINJAM_PAKAI' => 'Pinjam Pakai BMN',
                            default => $header->jenis_bast
                        } }}
                    </span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Tanggal Serah Terima:</span>
                    <span class="font-medium text-slate-800">{{ $header->tanggal_bast ? $header->tanggal_bast->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-500 block">Lokasi:</span>
                    <span class="font-medium text-slate-800">{{ $header->lokasi ?? 'Bawaslu' }}</span>
                </div>
            </div>
        </div>

        <!-- Para Pihak -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Pihak Pertama -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-red-700">Pihak Pertama</span>
                    @if($isSignedPihak1)
                        <span class="text-[11px] font-bold bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">✓ TTD Sah</span>
                    @else
                        <span class="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">Belum TTD</span>
                    @endif
                </div>
                <div class="text-xs text-slate-500">Yang Menyerahkan (Pejabat BMN)</div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">{{ $header->pihakPertama->nama ?? '-' }}</h4>
                    <p class="text-xs text-slate-600 mt-0.5">NIP. {{ $header->pihak_pertama_nip ?? '-' }}</p>
                    <p class="text-xs text-slate-500">{{ $header->pihakPertama->jabatan ?? 'Pejabat Penyerah' }}</p>
                </div>
            </div>

            <!-- Pihak Kedua -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-red-700">Pihak Kedua</span>
                    @if($isSignedPihak2)
                        <span class="text-[11px] font-bold bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">✓ TTD Sah</span>
                    @else
                        <span class="text-[11px] font-semibold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">Belum TTD</span>
                    @endif
                </div>
                <div class="text-xs text-slate-500">Yang Menerima (Pegawai Pemakai)</div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">{{ $header->pihak_kedua_display }}</h4>
                    @if($header->pihak_kedua_tipe === 'internal' && $header->pihakKedua)
                        <p class="text-xs text-slate-600 mt-0.5">NIP. {{ $header->pihak_kedua_nip }}</p>
                        <p class="text-xs text-slate-500">{{ $header->pihakKedua->jabatan ?? 'Pegawai' }} - {{ $header->pihakKedua->unit_kerja ?? '-' }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Rincian Barang BMN -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 space-y-3">
            <h3 class="text-sm font-bold text-slate-900 flex items-center justify-between">
                <span>Rincian Barang Milik Negara (BMN)</span>
                <span class="text-xs font-normal text-slate-500">{{ $details->count() }} Barang</span>
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-slate-600 font-semibold">
                            <th class="py-2.5 px-3">No</th>
                            <th class="py-2.5 px-3">Kode BMN</th>
                            <th class="py-2.5 px-3">Nama Barang</th>
                            <th class="py-2.5 px-3">NUP</th>
                            <th class="py-2.5 px-3">Merk / Tipe</th>
                            <th class="py-2.5 px-3">Kondisi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($details as $idx => $itemDetail)
                            <tr>
                                <td class="py-2.5 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-3 font-mono font-bold text-slate-800">{{ $itemDetail->item->kode_bmn ?? '-' }}</td>
                                <td class="py-2.5 px-3 font-medium text-slate-900">{{ $itemDetail->item->nama_barang ?? '-' }}</td>
                                <td class="py-2.5 px-3 font-mono text-slate-600">{{ $itemDetail->item->nup ?? '-' }}</td>
                                <td class="py-2.5 px-3 text-slate-600">{{ $itemDetail->item->merk ?? '-' }}</td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $itemDetail->kondisi_saat_ini ?? ($itemDetail->item->kondisi ?? 'Baik') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-slate-400">Tidak ada rincian barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Keamanan -->
        <div class="text-center text-[11px] text-slate-400 space-y-1 pt-2">
            <p>Halaman ini merupakan kanal resmi verifikasi dokumen elektronik BMN Bawaslu.</p>
            <p>Diverifikasi pada {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>

    </main>

</body>
</html>
