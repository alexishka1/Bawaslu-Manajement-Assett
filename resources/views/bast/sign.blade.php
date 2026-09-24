<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Tangan Digital BAST - Bawaslu Management Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .signature-canvas {
            touch-action: none;
            cursor: crosshair;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 pb-12">

    <!-- Navbar -->
    <header class="bg-gradient-to-r from-red-700 to-red-900 text-white shadow-md sticky top-0 z-30">
        <div class="max-w-4xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ $backUrl }}" class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-base font-bold tracking-tight">Tanda Tangan Digital BAST</h1>
                    <p class="text-xs text-red-200">Badan Pengawas Pemilihan Umum</p>
                </div>
            </div>
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-800/80 text-white border border-red-400/30">
                    {{ strtoupper($type) }}
                </span>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-6 space-y-6">

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                <svg class="w-6 h-6 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-bold text-sm">Berhasil Disimpan!</h3>
                    <p class="text-xs mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm">
                <svg class="w-6 h-6 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-bold text-sm">Terjadi Kesalahan</h3>
                    <p class="text-xs mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Card Informasi Dokumen & Switch Pihak -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-100 pb-3">
                <div>
                    <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Nomor Dokumen</span>
                    <h2 class="text-lg font-extrabold text-slate-900">{{ $nomorBast }}</h2>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-slate-500">Status:</span>
                    <span class="px-2.5 py-1 text-xs font-bold rounded-lg {{ $header->status_dokumen === 'final' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ strtoupper($header->status_dokumen) }}
                    </span>
                </div>
            </div>

            <!-- Switcher Pihak 1 vs Pihak 2 -->
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Pilih Pihak Penandatangan:</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    @php
                        $routeSwitch1 = ($type === 'pemakaian') ? route('bast.pemakaian.sign', [$header, 'pihak1']) : route('bast.pengembalian.sign', [$header, 'pihak1']);
                        $routeSwitch2 = ($type === 'pemakaian') ? route('bast.pemakaian.sign', [$header, 'pihak2']) : route('bast.pengembalian.sign', [$header, 'pihak2']);
                    @endphp

                    <a href="{{ $routeSwitch1 }}" 
                       class="p-3 rounded-xl border transition flex items-center justify-between {{ $pihak === 'pihak1' ? 'border-red-600 bg-red-50/70 text-red-950 font-bold ring-2 ring-red-500/20' : 'border-slate-200 bg-white hover:bg-slate-50 text-slate-600' }}">
                        <div class="flex items-center space-x-3">
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold {{ $pihak === 'pihak1' ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600' }}">1</span>
                            <div>
                                <div class="text-sm">Pihak Pertama</div>
                                <div class="text-xs text-slate-500 font-normal">
                                    {{ $type === 'pemakaian' ? 'Pejabat Penyerah' : 'Pegawai Mengembalikan' }}
                                </div>
                            </div>
                        </div>
                        <div>
                            @if($header->ttd_pihak1_url)
                                <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-semibold">✓ Ditandatangani</span>
                            @else
                                <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">Belum</span>
                            @endif
                        </div>
                    </a>

                    <a href="{{ $routeSwitch2 }}" 
                       class="p-3 rounded-xl border transition flex items-center justify-between {{ $pihak === 'pihak2' ? 'border-red-600 bg-red-50/70 text-red-950 font-bold ring-2 ring-red-500/20' : 'border-slate-200 bg-white hover:bg-slate-50 text-slate-600' }}">
                        <div class="flex items-center space-x-3">
                            <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold {{ $pihak === 'pihak2' ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600' }}">2</span>
                            <div>
                                <div class="text-sm">Pihak Kedua</div>
                                <div class="text-xs text-slate-500 font-normal">
                                    {{ $type === 'pemakaian' ? 'Pegawai Penerima' : 'Pejabat Menerima' }}
                                </div>
                            </div>
                        </div>
                        <div>
                            @if($header->ttd_pihak2_url)
                                <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-semibold">✓ Ditandatangani</span>
                            @else
                                <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-semibold">Belum</span>
                            @endif
                        </div>
                    </a>
                </div>
            </div>

            <!-- Detail Pihak Aktif -->
            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/60 text-sm">
                <div class="text-xs text-slate-500 font-semibold mb-0.5">{{ $peranPihak }}</div>
                <div class="text-base font-bold text-slate-900">{{ $namaPihak }}</div>
            </div>
        </div>

        <!-- Signature Pad Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Area Tanda Tangan Digital</h3>
                    <p class="text-xs text-slate-500">Gunakan jari tangan di layar HP/tablet atau mouse di PC</p>
                </div>
                @if($existingTtd)
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        ✓ Tanda Tangan Tersimpan
                    </span>
                @endif
            </div>

            @if($existingTtd)
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center justify-center">
                    <p class="text-xs text-slate-400 mb-1">Preview Tanda Tangan Saat Ini:</p>
                    <img src="{{ $existingTtd }}" alt="Tanda Tangan Tersimpan" class="h-24 object-contain bg-white rounded-lg p-2 border border-slate-200 shadow-inner">
                    <p class="text-[11px] text-slate-500 mt-2">Anda dapat membubuhkan tanda tangan baru di bawah ini untuk memperbarui.</p>
                </div>
            @endif

            <form action="{{ $submitUrl }}" method="POST" id="signatureForm" class="space-y-4">
                @csrf
                <input type="hidden" name="signature" id="signatureInput">

                <!-- Canvas Box -->
                <div class="relative w-full rounded-xl border-2 border-dashed border-slate-300 bg-white shadow-inner overflow-hidden flex flex-col items-center justify-center">
                    <canvas id="signaturePad" class="signature-canvas w-full h-56"></canvas>
                    
                    <div id="canvasPlaceholder" class="pointer-events-none absolute inset-0 flex items-center justify-center text-slate-300 text-sm font-medium">
                        ✍️ Goreskan Tanda Tangan Anda di Sini
                    </div>
                </div>

                <!-- Action Controls -->
                <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                    <button type="button" id="clearBtn" 
                            class="px-4 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Hapus / Ulangi</span>
                    </button>

                    <div class="flex items-center space-x-2">
                        <button type="submit" id="saveBtn"
                                class="px-5 py-2.5 text-xs font-bold text-white bg-red-700 hover:bg-red-800 active:scale-95 rounded-xl shadow-md transition flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Simpan & Konfirmasi Tanda Tangan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Daftar Barang BMN yang Diserahterimakan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5 space-y-3">
            <h3 class="text-sm font-bold text-slate-900 flex items-center space-x-2">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span>Daftar Aset BMN Terkait ({{ $items->count() }} Barang)</span>
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
                        @forelse($items as $index => $detail)
                            <tr class="hover:bg-slate-50/60">
                                <td class="py-2.5 px-3 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                <td class="py-2.5 px-3 font-mono font-bold text-slate-800">{{ $detail->item->kode_bmn ?? '-' }}</td>
                                <td class="py-2.5 px-3 font-medium text-slate-900">{{ $detail->item->nama_barang ?? '-' }}</td>
                                <td class="py-2.5 px-3 font-mono text-slate-600">{{ $detail->item->nup ?? '-' }}</td>
                                <td class="py-2.5 px-3 text-slate-600">{{ $detail->item->merk ?? '-' }}</td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ $detail->kondisi_saat_ini ?? ($detail->kondisi_saat_kembali ?? ($detail->item->kondisi ?? 'Baik')) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-slate-400">Belum ada rincian barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Canvas Logic Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById('signaturePad');
            const placeholder = document.getElementById('canvasPlaceholder');
            const clearBtn = document.getElementById('clearBtn');
            const form = document.getElementById('signatureForm');
            const input = document.getElementById('signatureInput');

            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            let hasDrawn = false;

            // Setup high resolution backing store for retina/mobile
            function resizeCanvas() {
                const rect = canvas.getBoundingClientRect();
                const ratio = window.devicePixelRatio || 1;

                canvas.width = rect.width * ratio;
                canvas.height = rect.height * ratio;

                ctx.scale(ratio, ratio);
                ctx.lineWidth = 2.5;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.strokeStyle = '#0f172a';
            }

            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            function getCoordinates(event) {
                const rect = canvas.getBoundingClientRect();
                if (event.touches && event.touches.length > 0) {
                    return {
                        x: event.touches[0].clientX - rect.left,
                        y: event.touches[0].clientY - rect.top
                    };
                }
                return {
                    x: event.clientX - rect.left,
                    y: event.clientY - rect.top
                };
            }

            function startDrawing(e) {
                e.preventDefault();
                isDrawing = true;
                const pos = getCoordinates(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
                if (placeholder) placeholder.style.display = 'none';
            }

            function draw(e) {
                if (!isDrawing) return;
                e.preventDefault();
                hasDrawn = true;
                const pos = getCoordinates(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }

            function stopDrawing() {
                if (isDrawing) {
                    ctx.closePath();
                    isDrawing = false;
                }
            }

            // Mouse events
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseleave', stopDrawing);

            // Touch events
            canvas.addEventListener('touchstart', startDrawing, { passive: false });
            canvas.addEventListener('touchmove', draw, { passive: false });
            canvas.addEventListener('touchend', stopDrawing);
            canvas.addEventListener('touchcancel', stopDrawing);

            // Clear canvas
            clearBtn.addEventListener('click', () => {
                const ratio = window.devicePixelRatio || 1;
                ctx.clearRect(0, 0, canvas.width / ratio, canvas.height / ratio);
                hasDrawn = false;
                if (placeholder) placeholder.style.display = 'flex';
            });

            // Form Submit validation
            form.addEventListener('submit', (e) => {
                if (!hasDrawn) {
                    e.preventDefault();
                    alert('Silakan goreskan tanda tangan Anda terlebih dahulu pada area canvas.');
                    return;
                }
                // Export canvas as PNG base64
                input.value = canvas.toDataURL('image/png');
            });
        });
    </script>
</body>
</html>
