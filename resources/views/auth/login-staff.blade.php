<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staf - Bawaslu Management Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        {{-- Header Bawaslu --}}
        <div class="bg-[#B91C1C] p-6 text-center text-white relative">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#D97706]/20 rounded-bl-full pointer-events-none"></div>
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Bawaslu" class="h-16 mx-auto mb-3 drop-shadow-md rounded bg-white p-1">
            <h1 class="text-2xl font-bold tracking-wide">Bawaslu Management Asset</h1>
            <p class="text-red-100 text-sm mt-1">Portal Laporan Lapangan Staf</p>
        </div>

        <div class="p-6 sm:p-8">
            {{-- Success Notification --}}
            @if (session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg text-sm mb-5">
                    <p class="font-semibold mb-0.5">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Warning Notification --}}
            @if (session('warning'))
                <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded-r-lg text-sm mb-5">
                    <p>{{ session('warning') }}</p>
                </div>
            @endif

            {{-- Error Notification --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-[#B91C1C] text-red-700 p-4 rounded-r-lg text-sm mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                        placeholder="email@bawaslu.go.id">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="password">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-[#B91C1C] focus:ring-[#B91C1C] mr-2"> Ingat Saya
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-[#B91C1C] hover:bg-[#991b1b] text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 text-sm">
                    Masuk
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-gray-100 text-center text-sm text-gray-600">
                Belum memiliki akun staf?
                <a href="{{ route('register') }}" class="text-[#B91C1C] hover:text-[#991b1b] font-semibold underline ml-1">
                    Daftar di sini
                </a>
            </div>
        </div>
        
        <div class="bg-gray-50 p-4 border-t border-gray-100 text-center text-xs text-gray-500">
            Hanya untuk staf internal Badan Pengawas Pemilihan Umum.
        </div>
    </div>

</body>
</html>
