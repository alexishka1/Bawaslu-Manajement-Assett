<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAWASLU Management Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen pb-10">

    <!-- Header -->
    <div class="bg-blue-600 text-white p-4 shadow-md flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold">BAWASLU</h1>
            <p class="text-xs text-blue-200">Management Asset</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm bg-blue-700 hover:bg-blue-800 px-3 py-1 rounded">Logout</button>
        </form>
    </div>

    <div class="max-w-md mx-auto mt-6 px-4">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm">
                <p class="font-bold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm">
                <p class="font-bold">Error</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Kartu Info Barang -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="bg-gray-800 text-white p-4">
                <h2 class="text-lg font-bold">{{ $item->nama_barang }}</h2>
                <p class="text-sm text-gray-300">{{ $item->kode_bmn }}</p>
            </div>
            
            @if($item->foto)
                <img src="{{ Storage::url($item->foto) }}" alt="Foto Barang" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                    Tidak ada foto
                </div>
            @endif

            <div class="p-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Kategori</p>
                        <p class="font-semibold">{{ $item->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Status Database</p>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold uppercase">
                            {{ $item->status }}
                        </span>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500 mb-1">Lokasi Tercatat</p>
                        <p class="font-semibold">{{ $item->lokasi_simpan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Laporan -->
        <div class="bg-white rounded-xl shadow-md p-5 border-t-4 border-blue-500">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Laporan Kondisi Aktual
            </h3>
            
            <form action="{{ route('scan.store', $item->kode_bmn) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Pelapor</label>
                    <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full px-3 py-2 bg-gray-100 border rounded-lg text-gray-600">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="kondisi_aktual">Kondisi Saat Ini <span class="text-red-500">*</span></label>
                    <select id="kondisi_aktual" name="kondisi_aktual" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="tersedia">Sesuai / Baik (Tersedia)</option>
                        <option value="terpakai">Sedang Dipakai Orang (Terpakai)</option>
                        <option value="servis">Perlu Perbaikan (Servis)</option>
                        <option value="rusak">Kondisi Rusak</option>
                        <option value="hilang">Barang Tidak Ditemukan (Hilang)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="foto_bukti">
                        Foto Bukti Fisik <span class="text-red-500">*</span>
                    </label>
                    <!-- Menggunakan capture="environment" untuk memaksa kamera belakang -->
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center hover:bg-gray-50 transition bg-blue-50">
                        <svg class="w-8 h-8 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-sm font-medium text-blue-600">Ambil Foto Pakai Kamera</span>
                        <input type="file" id="foto_bukti" name="foto_bukti" accept="image/*" capture="environment" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">Wajib memotret langsung dari kamera HP.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="catatan">Catatan / Detail Lokasi</label>
                    <textarea id="catatan" name="catatan" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Barang ditemukan di gudang C, tidak sesuai data Admin."></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 flex justify-center items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim Laporan
                </button>
            </form>
        </div>
    </div>

</body>
</html>
