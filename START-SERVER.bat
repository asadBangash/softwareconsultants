@echo off
REM Start Local Dev Server with clean URLs (no .html in address bar)
cd /d "%~dp0"

echo.
echo ========================================
echo  Software Consultants - Dev Server
echo ========================================
echo.
echo Clean URLs: http://localhost:8000/about
echo Do NOT open HTML files directly from the folder.
echo.

where php >nul 2>nul
if %errorlevel%==0 (
    echo Starting PHP server...
    php -S localhost:8000 router.php
    goto :end
)

where python >nul 2>nul
if %errorlevel%==0 (
    echo Starting Python server...
    python server.py
    goto :end
)

where python3 >nul 2>nul
if %errorlevel%==0 (
    echo Starting Python server...
    python3 server.py
    goto :end
)

echo ERROR: Install PHP or Python to run the local dev server.
echo.
pause

:end
