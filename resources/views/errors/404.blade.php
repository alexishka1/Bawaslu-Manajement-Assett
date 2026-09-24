<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman / Aset Tidak Ditemukan | BAWASLU Management Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="hero-pattern min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-gray-100 p-8 text-center">
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span class="inline-block px-3 py-1 text-xs font-bold text-blue-700 bg-blue-50 rounded-full mb-3 uppercase tracking-wider">
            HTTP 404 Not Found
        </span>
        <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Tidak Ditemukan</h1>
        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
            {{ $exception->getMessage() ?: 'Halaman, dokumen, atau data aset BMN yang Anda cari tidak dapat ditemukan atau telah dipindahkan.' }}
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}" class="inline-flex justify-center items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                Kembali ke Beranda
            </a>
            <a href="{{ url('/scan') }}" class="inline-flex justify-center items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition">
                Scanner QR
            </a>
        </div>
        <div class="mt-8 pt-6 border-t border-gray-100 text-xs text-gray-400">
            BAWASLU Asset Management System
        </div>
    </div>
</body>
</html>
