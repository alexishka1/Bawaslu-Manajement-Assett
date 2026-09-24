<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Staf - Bawaslu Management Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4 py-8">

    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
        {{-- Header Bawaslu --}}
        <div class="bg-[#B91C1C] p-6 text-center text-white relative">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#D97706]/20 rounded-bl-full pointer-events-none"></div>
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo Bawaslu" class="h-16 mx-auto mb-3 drop-shadow-md rounded bg-white p-1">
            <h1 class="text-2xl font-bold tracking-wide">Bawaslu Management Asset</h1>
            <p class="text-red-100 text-sm mt-1">Pendaftaran Akun Pegawai & Staf Lapangan</p>
        </div>

        <div class="p-6 sm:p-8">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-[#B91C1C] text-red-700 p-4 rounded-r-lg text-sm mb-6">
                    <p class="font-semibold mb-1">Periksa kembali data yang dimasukkan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Info Notice --}}
            <div class="bg-amber-50 border border-amber-200 text-amber-800 p-3.5 rounded-xl text-xs mb-6 flex items-start gap-2.5">
                <span class="text-base">ℹ️</span>
                <div>
                    <strong>Pemberitahuan:</strong> Akun pegawai yang baru didaftarkan akan berstatus <em>pending</em> dan memerlukan verifikasi serta persetujuan Administrator Bawaslu sebelum dapat digunakan untuk login.
                </div>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="name">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                        placeholder="Contoh: Budi Santoso, S.Kom">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="nip">
                            NIP <span class="text-gray-400 font-normal text-xs">(Opsional)</span>
                        </label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                            placeholder="19890101...">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="jabatan">
                            Jabatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required
                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                            placeholder="Staf IT / Pranata Humas">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="unit_kerja">
                        Unit Kerja / Divisi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="unit_kerja" name="unit_kerja" value="{{ old('unit_kerja') }}" required
                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                        placeholder="Contoh: Subbagian Pengawasan & Humas">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="email">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                        placeholder="nama@bawaslu.go.id">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="password">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                            placeholder="Min. 8 karakter">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1.5" for="password_confirmation">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-transparent transition"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-[#B91C1C] hover:bg-[#991b1b] text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 text-sm flex items-center justify-center gap-2">
                        <span>📝</span>
                        <span>Daftarkan Akun Pegawai</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-gray-100 text-center text-sm text-gray-600">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="text-[#B91C1C] hover:text-[#991b1b] font-semibold underline ml-1">
                    Masuk di sini
                </a>
            </div>
        </div>

        <div class="bg-gray-50 p-4 border-t border-gray-100 text-center text-xs text-gray-500">
            Badan Pengawas Pemilihan Umum Republik Indonesia &copy; {{ date('Y') }}
        </div>
    </div>

</body>
</html>
