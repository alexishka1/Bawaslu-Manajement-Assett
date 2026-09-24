<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BastController;
use App\Http\Controllers\BastSignatureController;
use App\Http\Controllers\BastVerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\ScanController;
use App\Models\Item;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Verifikasi Publik Keabsahan Dokumen BAST (Hasil Scan QR Code)
Route::get('/verify/bast-pemakaian/{header}', [BastVerificationController::class, 'verifyPemakaian'])->name('bast.pemakaian.verify');
Route::get('/verify/bast-pengembalian/{header}', [BastVerificationController::class, 'verifyPengembalian'])->name('bast.pengembalian.verify');

// Tanda Tangan Digital BAST (Bisa diakses dari Layar Komputer / Scan HP Pegawai)
Route::get('/bast-pemakaian/{header}/sign/{pihak}', [BastSignatureController::class, 'showPemakaian'])->name('bast.pemakaian.sign');
Route::post('/bast-pemakaian/{header}/sign/{pihak}', [BastSignatureController::class, 'storePemakaian'])->middleware('throttle:20,1')->name('bast.pemakaian.sign.store');
Route::get('/bast-pengembalian/{header}/sign/{pihak}', [BastSignatureController::class, 'showPengembalian'])->name('bast.pengembalian.sign');
Route::post('/bast-pengembalian/{header}/sign/{pihak}', [BastSignatureController::class, 'storePengembalian'])->middleware('throttle:20,1')->name('bast.pengembalian.sign.store');

// Auth Routes (Staff)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1')->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= STAFF AREA =================
Route::middleware(['auth'])->group(function () {
    Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
    Route::get('/scan/{kode_bmn}', [ScanController::class, 'show'])->name('scan.show');
    Route::post('/scan/{kode_bmn}', [ScanController::class, 'store'])->middleware('throttle:30,1')->name('scan.store');
});

// ================= SHARED (Admin & Staff, perlu login) =================
Route::middleware(['auth'])->group(function () {
    Route::get('/bast/{transaction}/download', [BastController::class, 'download'])->name('bast.download');
    Route::get('/bast-pemakaian/{header}/download', [BastController::class, 'downloadPemakaian'])->name('bast.pemakaian.download');
    Route::get('/bast-pengembalian/{header}/download', [BastController::class, 'downloadPengembalian'])->name('bast.pengembalian.download');

    // Ruangan: Cetak DIR & Unduh QR Pintu Ruangan
    Route::get('/ruangan/{ruangan}/dir', [RuanganController::class, 'downloadDir'])->name('ruangan.download-dir');
    Route::get('/ruangan/{ruangan}/qr', [RuanganController::class, 'downloadQr'])->name('ruangan.download-qr');

    // Scan Ruangan & Mutasi Cepat
    Route::get('/scan/ruangan/{kode_ruangan}', [RuanganController::class, 'show'])->name('ruangan.show');
    Route::post('/scan/ruangan/{kode_ruangan}', [RuanganController::class, 'pindahBarang'])->middleware('throttle:30,1')->name('ruangan.pindah-barang');

    // QR Code print sheet & download admin-only (fitur cetak label aset)
    Route::get('/qrcode/print-sheet', [QrCodeController::class, 'printSheet'])
        ->name('qrcode.print-sheet')
        ->middleware('role:admin');

    Route::get('/qrcode/{item}/download', [QrCodeController::class, 'download'])
        ->name('qrcode.download')
        ->middleware('role:admin');
});

// ================= ADMIN ONLY =================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/fix-qr', function () {
        Item::all()->each(function ($item) {
            $item->update(['qr_code' => url('/scan/'.$item->kode_bmn)]);
        });

        return 'Semua QR Code berhasil di-update dengan URL: '.url('/');
    })->name('admin.fix-qr');
});
