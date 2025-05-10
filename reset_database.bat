@echo off
REM =====================================================
REM Script Reset Database Naga Hytam (Windows)
REM =====================================================

REM ——— Konfigurasi ——————————————————————————————
set "MYSQL_USER=root"
set "MYSQL_PASS="
set "DB_NAME=naga_hytam"
set "DUMP_FILE=naga_hytam.sql"
set "MYSQL_BIN=C:\xampp\mysql\bin"

REM Jika password kosong, kita omit flag -p
if "%MYSQL_PASS%"=="" (
    set "PASS_ARG="
) else (
    set "PASS_ARG=-p%MYSQL_PASS%"
)

echo.
echo ====================================================
echo   RESET DATABASE %DB_NAME%
echo ====================================================
echo.

echo [1] Dropping database %DB_NAME% (if exists)...
"%MYSQL_BIN%\mysql.exe" -u %MYSQL_USER% %PASS_ARG% -e "DROP DATABASE IF EXISTS %DB_NAME%;"

echo [2] Creating database %DB_NAME%...
"%MYSQL_BIN%\mysql.exe" -u %MYSQL_USER% %PASS_ARG% -e "CREATE DATABASE %DB_NAME% CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if not exist "%DUMP_FILE%" (
    echo [ERROR] File dump "%DUMP_FILE%" tidak ditemukan!
    pause
    exit /b 1
)

echo [3] Importing dump from %DUMP_FILE%...
"%MYSQL_BIN%\mysql.exe" -u %MYSQL_USER% %PASS_ARG% %DB_NAME% < "%DUMP_FILE%"

echo.
echo ====================================================
echo   Database %DB_NAME% berhasil di–reset!
echo ====================================================
echo.
pause
