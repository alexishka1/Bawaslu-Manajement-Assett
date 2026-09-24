@echo off
title BAWASLU MANAGEMENT ASSET - SERVER LAUNCHER
color 0A
cls
echo =====================================================================
echo           MEMULAI SEMUA SERVER BAWASLU MANAGEMENT ASSET
echo =====================================================================
echo.

cd /d "%~dp0"

echo [1/3] Menyalakan Web Server Laravel (Port 8000)...
start "Bawaslu - Web Server" /min php artisan serve --host=0.0.0.0 --port=8000

echo [2/3] Menyalakan Queue Worker (Antrean & Notifikasi)...
start "Bawaslu - Queue Worker" /min php artisan queue:listen --tries=1

echo [3/3] Menghubungkan Cloudflare Tunnel (Domain Publik)...
start "Bawaslu - Tunnel" /min cloudflared.exe tunnel --protocol http2 run bawaslu-tunnel

timeout /t 3 >nul
echo.
echo =====================================================================
echo                    SEMUA SERVER SUDAH AKTIF!
echo =====================================================================
echo.
echo * Web Admin (Laptop)  : http://localhost:8000/admin
echo * Portal Staf (HP)    : https://bawaslumanagementasset.my.id/scan
echo * Lembar Cetak QR     : http://localhost:8000/qrcode/print-sheet
echo.
echo Membuka halaman dasbor admin di browser Anda...
start http://localhost:8000/admin
echo.
echo Tekan tombol apa saja untuk menutup jendela peluncur ini
echo (Server akan tetap terus berjalan di latar belakang).
pause >nul
