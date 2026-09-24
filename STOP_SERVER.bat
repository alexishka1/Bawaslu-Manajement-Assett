@echo off
title BAWASLU MANAGEMENT ASSET - STOP SERVERS
color 0C
cls
echo =====================================================================
echo           MEMATIKAN SEMUA SERVER BAWASLU MANAGEMENT ASSET
echo =====================================================================
echo.

echo Menghentikan proses PHP (Web Server & Queue Worker)...
taskkill /f /im php.exe >nul 2>&1

echo Menghentikan proses Cloudflare Tunnel...
taskkill /f /im cloudflared.exe >nul 2>&1

echo.
echo =====================================================================
echo                SEMUA SERVER TELAH DIMATIKAN!
echo =====================================================================
echo.
pause
