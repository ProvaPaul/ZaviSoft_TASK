@echo off
title Task 1 - SSO Servers

echo ================================================
echo  Task 1: Multi Login SSO System
echo  Ecommerce App  -^>  http://127.0.0.1:8000
echo  Foodpanda App  -^>  http://127.0.0.1:8001
echo ================================================
echo.

echo [*] Stopping any existing PHP servers...
taskkill /F /IM php.exe >nul 2>&1
timeout /t 2 /nobreak >nul

echo [*] Starting Ecommerce App on port 8000...
start "Ecommerce App :8000" /D "C:\xampp\htdocs\ZaviSoft_TASK\Task1\ecommerce-app" C:\xampp\php\php.exe artisan serve --host=127.0.0.1 --port=8000

timeout /t 2 /nobreak >nul

echo [*] Starting Foodpanda App on port 8001...
start "Foodpanda App :8001" /D "C:\xampp\htdocs\ZaviSoft_TASK\Task1\foodpanda-app" C:\xampp\php\php.exe artisan serve --host=127.0.0.1 --port=8001

timeout /t 3 /nobreak >nul

echo.
echo ================================================
echo  READY! Both servers running.
echo.
echo  [Ecommerce]  http://127.0.0.1:8000
echo  [Foodpanda]  http://127.0.0.1:8001
echo.
echo  Demo Login:  admin@ecommerce.test / password
echo.
echo  SSO Flow:
echo    1. Open http://127.0.0.1:8000
echo    2. Login with demo credentials
echo    3. Click "Go to Foodpanda" button
echo    4. Auto-logged into Foodpanda!
echo ================================================
echo.

echo [*] Opening Ecommerce App in browser...
start "" "http://127.0.0.1:8000"

pause
