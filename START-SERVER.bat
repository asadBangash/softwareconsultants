@echo off
REM Start Local Web Server for Software Consultants Website
REM This script starts a Python HTTP server (works on Windows 10+)

echo.
echo ========================================
echo  Software Consultants - Local Test Server
echo ========================================
echo.

REM Get the directory where this script is located
cd /d "%~dp0"

echo Starting web server on http://localhost:8000
echo.
echo Once the server starts:
echo 1. Open your browser
echo 2. Go to: http://localhost:8000/contact
echo 3. Test the contact form
echo.
echo Press Ctrl+C to stop the server
echo.

REM Start Python HTTP server (built-in to Python 3.x)
python -m http.server 8000

REM If Python is not found, try python3
if errorlevel 1 (
    echo Python not found. Trying python3...
    python3 -m http.server 8000
)

if errorlevel 1 (
    echo.
    echo ERROR: Python is not installed or not in PATH
    echo.
    echo SOLUTION 1: Install Python from https://www.python.org/
    echo SOLUTION 2: Use the alternative batch file (php-server.bat)
    echo SOLUTION 3: Upload to Hostinger and test directly on live site
    echo.
    pause
)
