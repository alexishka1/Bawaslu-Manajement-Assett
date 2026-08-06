<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner - BAWASLU Management Asset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Load HTML5 QR Code Library -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen pb-10 flex flex-col">

    <!-- Header -->
    <div class="bg-blue-600 text-white p-4 shadow-md flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-white hover:text-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-bold tracking-tight">Kamera Scanner</h1>
        <div class="w-6"></div> <!-- Placeholder untuk spasi -->
    </div>

    <!-- Scanner Container -->
    <div class="flex-grow flex flex-col justify-center items-center p-4">
        <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Scan QR Code Barang</h2>
                <p class="text-gray-500 text-sm">Arahkan kamera ke QR Code yang tertempel di barang BMN</p>
            </div>
            
            <!-- Elemen ini akan dipakai library HTML5-QRCode -->
            <div id="reader" class="w-full rounded-lg overflow-hidden border-2 border-dashed border-blue-300"></div>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>Otomatis mengarahkan ke halaman laporan saat terdeteksi.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", 
                { fps: 10, qrbox: {width: 250, height: 250}, aspectRatio: 1.0 }
            );

            function onScanSuccess(decodedText, decodedResult) {
                // Hentikan scanner saat berhasil
                html5QrcodeScanner.clear();
                
                // Cek apakah hasil scan berupa URL (contoh: http://192.168.1.x:8000/scan/BMN-123)
                if (decodedText.startsWith("http://") || decodedText.startsWith("https://")) {
                    window.location.href = decodedText;
                } else {
                    // Atau mungkin hanya kodenya saja (BMN-123)
                    window.location.href = "/scan/" + decodedText;
                }
            }

            function onScanFailure(error) {
                // Abaikan error saat scanning berlangsung
            }

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });
    </script>
</body>
</html>
