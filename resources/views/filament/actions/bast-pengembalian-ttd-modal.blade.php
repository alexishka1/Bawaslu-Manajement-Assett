@php
    $urlPihak1 = route('bast.pengembalian.sign', [$record, 'pihak1']);
    $urlPihak2 = route('bast.pengembalian.sign', [$record, 'pihak2']);
    
    // QR Code untuk Pihak 1 (Pegawai Pengembali) agar bisa langsung scan dari smartphone
    $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(150)->margin(1)->generate($urlPihak1);
    $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
@endphp

<div class="space-y-5 text-slate-800">

    <!-- Ringkasan Info Dokumen -->
    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs space-y-1.5">
        <div class="flex justify-between items-center">
            <span class="text-slate-500 font-medium">Nomor Dokumen:</span>
            <span class="font-bold text-slate-900 font-mono">{{ $record->nomor_bast_pengembalian ?? 'DRAFT (Belum Terbit)' }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-slate-500 font-medium">Pengembali:</span>
            <span class="font-semibold text-slate-800">{{ $record->pihak_menyerahkan_display }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-slate-500 font-medium">Status Dokumen:</span>
            <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] {{ $record->status_dokumen === 'final' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                {{ $record->status_dokumen }}
            </span>
        </div>
    </div>

    <!-- Status TTD Kedua Belah Pihak -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <!-- Pihak 1 (Pengembali) -->
        <div class="p-3.5 rounded-xl border {{ $record->ttd_pihak1_url ? 'border-emerald-200 bg-emerald-50/50' : 'border-slate-200 bg-white' }} space-y-2.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-700">Pihak 1 (Pengembali)</span>
                @if($record->ttd_pihak1_url)
                    <span class="text-[11px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">✓ TTD Sah</span>
                @else
                    <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Belum TTD</span>
                @endif
            </div>
            <div class="text-xs text-slate-600">
                <div class="font-medium text-slate-900 truncate">{{ $record->pihak_menyerahkan_display }}</div>
                <div class="text-[11px] text-slate-500">Pegawai Menyerahkan</div>
            </div>
            <a href="{{ $urlPihak1 }}" target="_blank"
               class="inline-flex items-center justify-center w-full px-3 py-1.5 text-xs font-semibold text-white bg-red-700 hover:bg-red-800 rounded-lg shadow-sm transition">
                ✍️ Buka Layar TTD Pengembali
            </a>
        </div>

        <!-- Pihak 2 (Pejabat Penerima) -->
        <div class="p-3.5 rounded-xl border {{ $record->ttd_pihak2_url ? 'border-emerald-200 bg-emerald-50/50' : 'border-slate-200 bg-white' }} space-y-2.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-700">Pihak 2 (Pejabat BMN)</span>
                @if($record->ttd_pihak2_url)
                    <span class="text-[11px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">✓ TTD Sah</span>
                @else
                    <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Belum TTD</span>
                @endif
            </div>
            <div class="text-xs text-slate-600">
                <div class="font-medium text-slate-900 truncate">{{ $record->pihakMenerima->nama ?? 'Pejabat Penerima' }}</div>
                <div class="text-[11px] text-slate-500">NIP. {{ $record->pihak_menerima_nip ?? '-' }}</div>
            </div>
            <a href="{{ $urlPihak2 }}" target="_blank"
               class="inline-flex items-center justify-center w-full px-3 py-1.5 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded-lg shadow-sm transition">
                ✍️ Buka Layar TTD Pejabat
            </a>
        </div>
    </div>

    <!-- QR Code Scan via Smartphone Pegawai -->
    <div class="p-4 bg-gradient-to-br from-slate-50 to-red-50/30 rounded-xl border border-red-100 flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
        <div class="p-2 bg-white rounded-xl shadow-sm border border-slate-200 flex-shrink-0">
            <img src="{{ $qrBase64 }}" alt="QR TTD Pegawai" class="w-28 h-28">
        </div>
        <div class="space-y-1">
            <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-800 rounded-md">
                Fitur Paperless Mobile
            </span>
            <h4 class="text-xs font-bold text-slate-900">Scan QR untuk TTD di HP Pegawai</h4>
            <p class="text-[11px] text-slate-600 leading-relaxed">
                Minta pegawai yang mengembalikan barang untuk mengarahkan kamera smartphone ke QR Code ini agar bisa langsung menandatangani di layar HP mereka.
            </p>
            <div class="pt-1">
                <a href="{{ $urlPihak1 }}" target="_blank" class="text-[11px] font-semibold text-red-700 hover:underline">
                    Atau salin tautan tanda tangan langsung &rarr;
                </a>
            </div>
        </div>
    </div>

</div>
