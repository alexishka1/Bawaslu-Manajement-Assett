<?php

use App\Http\Controllers\BastController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes (Staff)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dilindungi auth (Staff dan Admin)
Route::middleware(['auth'])->group(function () {
    // Admin Only Cetak BAST & QR Code
    Route::get('/bast/{transaction}/download', [BastController::class, 'download'])->name('bast.download');
    Route::get('/bast-pemakaian/{header}/download', [BastController::class, 'downloadPemakaian'])->name('bast.pemakaian.download');
    Route::get('/bast-pengembalian/{header}/download', [BastController::class, 'downloadPengembalian'])->name('bast.pengembalian.download');
    Route::get('/qrcode/{item}/download', [QrCodeController::class, 'download'])->name('qrcode.download');

    // Scan Routes (Staff - Authenticated)
    Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
    Route::get('/scan/{kode_bmn}', [ScanController::class, 'show'])->name('scan.show');
    Route::post('/scan/{kode_bmn}', [ScanController::class, 'store'])->name('scan.store');
});

Route::get('/fix-qr', function () {
    \App\Models\Item::all()->each(function ($item) {
        $item->update(['qr_code' => url('/scan/' . $item->kode_bmn)]);
    });
    return 'Semua QR Code berhasil di-update dengan URL: ' . url('/');
});

Route::get('/test-qr', function () {
    $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(400)->generate('http://192.168.1.177:8000/scan/BMN-ELK-01');
    return "<body style='background:#f3f4f6; font-family:sans-serif; margin:0;'><div style='display:flex; justify-content:center; align-items:center; height:100vh; flex-direction:column;'><h1 style='color:#1f2937;'>QR Code Dummy (BMN-ELK-01)</h1><div style='margin:20px; padding:20px; background:white; border-radius:10px; box-shadow:0 4px 6px rgba(0,0,0,0.1);'>" . $qr . "</div><p style='color:#4b5563; font-size:18px;'>Arahkan kamera HP lo ke kotak QR ini!</p></div></body>";
});