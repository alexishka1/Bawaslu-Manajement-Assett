<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris {{ $ruangan->nama_ruangan }} - BAWASLU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen pb-12">

    <!-- Header Ruangan -->
    <header class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white shadow-lg sticky top-0 z-10">
        <div class="max-w-3xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-white/20 text-xs font-semibold tracking-wider uppercase mb-1">
                        {{ $ruangan->kode_ruangan }} &bull; {{ $ruangan->lantai }}
                    </span>
                    <h1 class="text-xl md:text-2xl font-black leading-tight">{{ $ruangan->nama_ruangan }}</h1>
                    <p class="text-blue-100 text-xs mt-0.5">{{ $ruangan->gedung }}</p>
                </div>
                <div class="text-right">
                    <a href="{{ url('/') }}" class="text-xs text-white/80 hover:text-white bg-white/10 px-3 py-1.5 rounded-lg border border-white/20">
                        Beranda
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 mt-6">

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-4 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm text-sm text-emerald-800">
                <strong>Sukses!</strong> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm text-sm text-rose-800">
                <strong>Gagal:</strong> {{ session('error') }}
            </div>
        @endif

        <!-- Card PIC & Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-slate-400 block font-medium">Penanggung Jawab</span>
                    <span class="font-bold text-slate-800 text-sm">{{ $ruangan->penanggung_jawab ?? 'Belum ditentukan' }}</span>
                    @if($ruangan->nip_penanggung_jawab)
                        <span class="text-slate-500 block">NIP. {{ $ruangan->nip_penanggung_jawab }}</span>
                    @endif
                </div>
                <div class="text-right">
                    <span class="text-slate-400 block font-medium">Total Aset Tercatat</span>
                    <span class="text-2xl font-black text-blue-600">{{ $ruangan->items->count() }}</span>
                    <span class="text-slate-500 block">Unit Barang</span>
                </div>
            </div>

            <!-- Form Pindah Barang ke Ruangan Ini -->
            <div class="mt-4 pt-4 border-t border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm mb-2 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Pindahkan / Daftarkan Barang ke Ruangan Ini
                </h3>
                <form action="{{ route('ruangan.pindah-barang', $ruangan->kode_ruangan) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                    @csrf
                    <input type="text" name="kode_bmn" required placeholder="Ketik / Scan Kode BMN (misal: BMN-001)" 
                        class="flex-1 px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none uppercase font-mono">
                    <input type="text" name="alasan" placeholder="Alasan (opsional)" 
                        class="flex-1 px-3 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition shadow-sm">
                        Simpan ke Ruangan
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Aset di Ruangan Ini -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-bold text-slate-900">Daftar Barang Milik Negara (DIR)</h2>
                <a href="{{ route('ruangan.download-dir', $ruangan->id) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download Lembar DIR (PDF)
                </a>
            </div>

            <div class="space-y-3">
                @forelse($ruangan->items as $item)
                    <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-xs font-mono font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">
                                    {{ $item->kode_bmn }}
                                </span>
                                <h3 class="font-bold text-slate-800 text-sm mt-1">{{ $item->nama_barang }}</h3>
                                <p class="text-xs text-slate-500">Kategori: {{ $item->kategori }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                                    @if($item->status == 'tersedia') bg-emerald-100 text-emerald-800
                                    @elseif($item->status == 'terpakai') bg-blue-100 text-blue-800
                                    @elseif($item->status == 'servis') bg-amber-100 text-amber-800
                                    @else bg-rose-100 text-rose-800 @endif">
                                    {{ $item->status }}
                                </span>
                                <a href="{{ url('/scan/' . $item->kode_bmn) }}" class="block text-xs text-blue-600 hover:underline mt-2">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-8 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        <p class="font-medium text-sm">Belum ada aset BMN di ruangan ini</p>
                        <p class="text-xs text-slate-400 mt-1">Gunakan formulir di atas untuk mendaftarkan aset yang berada di ruangan ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

</body>
</html>
