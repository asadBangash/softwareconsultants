@echo off
REM Start Local Web Server using PHP (Alternative to Python)
REM This script requires PHP to be installed

echo.
echo ========================================
echo  Software Consultants - PHP Local Server
echo ========================================
echo.

REM Get the directory where this script is located
cd /d "%~dp0"

echo Starting PHP web server on http://localhost:8000
echo.
echo Port: 8000
echo URL: http://localhost:8000/contact
echo.
echo Press Ctrl+C to stop the server
echo.

REM Start PHP built-in server
php -S localhost:8000

if errorlevel 1 (
    echo.
    echo ERROR: PHP is not installed or not in PATH
    echo.
    echo SOLUTIONS:
    echo 1. Install PHP from: https://windows.php.net/download/
    echo 2. Or use START-SERVER.bat (Python version)
    echo 3. Or upload to Hostinger and test directly
    echo.
    pause
)
