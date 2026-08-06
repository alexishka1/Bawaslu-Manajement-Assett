<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAWASLU Management Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm fixed w-full z-10 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <!-- Logo Bawaslu -->
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Bawaslu" class="h-12 w-auto">
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">BAWASLU <span class="text-blue-600">Management Asset</span></span>
                </div>
                <div>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-red-600 transition-colors">
                                Keluar
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center hero-pattern pt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold mb-6 animate-pulse">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Sistem Terpadu Aktif
            </div>

            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-4">
                BAWASLU <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">
                    Management Asset
                </span>
            </h1>
            
            <p class="mt-4 max-w-2xl text-lg md:text-xl text-gray-500 mx-auto mb-10">
                Pusat informasi dan pemantauan inventaris aset Bawaslu. Lakukan pelaporan kondisi barang dengan cepat dan akurat langsung dari smartphone Anda.
            </p>


            <!-- Action Buttons -->
            <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <!-- Box Kiri: Admin -->
                    <a href="{{ auth()->user()->role === 'admin' ? '/admin' : '#' }}" class="group relative flex flex-col items-center justify-center p-6 bg-white border-2 {{ auth()->user()->role === 'admin' ? 'border-gray-900 shadow-md hover:bg-gray-50' : 'border-gray-200 opacity-60 cursor-not-allowed' }} rounded-2xl transition-all w-full sm:w-64 cursor-pointer">
                        <div class="w-12 h-12 {{ auth()->user()->role === 'admin' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-400' }} rounded-full flex items-center justify-center mb-4 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">Dashboard Admin</span>
                        <span class="text-xs text-gray-500 mt-2 text-center">Kelola data aset, transaksi, dan laporan</span>
                        
                        @if(auth()->user()->role === 'admin')
                            <span class="mt-4 text-xs font-bold text-white bg-gray-900 px-4 py-1.5 rounded-full">Buka Dashboard</span>
                        @else
                            <span class="mt-4 text-xs font-bold text-red-500 bg-red-50 px-3 py-1 rounded-full">Bukan Admin</span>
                        @endif
                    </a>

                    <!-- Box Kanan: Staf -->
                    <a href="{{ route('scan.index') }}" class="group relative flex flex-col items-center justify-center p-6 bg-white border-2 border-blue-600 shadow-md hover:bg-blue-50 rounded-2xl transition-all w-full sm:w-64 cursor-pointer">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <span class="font-bold text-blue-600">Scanner Staf</span>
                        <span class="text-xs text-gray-500 mt-2 text-center">Akses lapor aset terbuka. Scan QR Code barang dari HP Anda.</span>
                        
                        <div class="mt-4 text-xs font-bold text-white bg-blue-600 px-4 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zM3 13a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zM13 3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4a1 1 0 00-1-1h-3zm1 2v1h1V5h-1z" clip-rule="evenodd" /></svg>
                            Buka Kamera
                        </div>
                    </a>
                @else
                    <a href="/admin" class="group relative flex flex-col items-center justify-center p-6 bg-white border-2 border-gray-200 rounded-2xl hover:border-gray-900 transition-all w-full sm:w-64 cursor-pointer">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-gray-900 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">Login Admin</span>
                        <span class="text-xs text-gray-500 mt-2 text-center">Kelola data aset, transaksi, dan laporan</span>
                    </a>

                    <a href="{{ route('login') }}" class="group relative flex flex-col items-center justify-center p-6 bg-white border-2 border-blue-200 rounded-2xl hover:border-blue-600 transition-all w-full sm:w-64 cursor-pointer">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <span class="font-bold text-blue-600">Login Staf</span>
                        <span class="text-xs text-gray-500 mt-2 text-center">Akses scan QR dan lapor kondisi aset lapangan</span>
                    </a>
                @endauth
            </div>
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} Badan Pengawas Pemilihan Umum. All rights reserved.
    </footer>

</body>
</html>
