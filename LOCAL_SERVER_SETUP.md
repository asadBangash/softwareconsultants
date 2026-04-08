# Local Testing Guide - Using a Web Server

## ⚠️ Why You're Getting Network Error

**The Problem:**
- You're opening `contact.html` directly as a file (`file:///` protocol)
- The browser blocks this due to CORS security policies
- Fetch requests don't work with `file://` URLs

**The Solution:**
- Use a local web server (PHP, Node.js, Python, etc.)
- Test on `http://localhost` instead of `file://`

---

## Option 1: Using PHP Built-in Server (EASIEST) ⭐

### Windows Setup:

**Step 1: Install PHP**
1. Download from: https://windows.php.net/download/
2. Choose "Zip" version (non-thread safe recommended)
3. Extract to `C:\php`
4. Add PHP to Windows PATH:
   - Search "Environment Variables" in Windows
   - Click "Edit the system environment variables"
   - Click "Environment Variables"
   - Under "System variables", find "Path"
   - Click Edit → New → Add `C:\php`
   - Click OK and restart terminal

**Step 2: Start Server**
1. Open Command Prompt
2. Navigate to your project folder:
   ```bash
   cd "e:\Software Consultants\Qais bahudur --\softwareconsultantswebsite\software_consultants (3)\software_consultants"
   ```

3. Start PHP server:
   ```bash
   php -S localhost:8000
   ```

4. Open browser and go to:
   ```
   http://localhost:8000
   ```

5. Navigate to `/contact` to test the form

**To Stop Server:** Press `Ctrl + C` in the terminal

---

## Option 2: Using XAMPP (Full Apache + PHP) 

### Installation:
1. Download XAMPP: https://www.apachefriends.org/
2. Install to default location
3. Start XAMPP Control Panel
4. Click "Start" next to Apache and MySQL
5. Place your website files in: `C:\xampp\htdocs\software_consultants`
6. Open browser: `http://localhost/software_consultants`

---

## Option 3: Using Node.js Server (Alternative)

### If you have Node.js installed:
```bash
# Install http-server globally
npm install -g http-server

# Navigate to your project folder
cd "your/project/path"

# Start server
http-server -p 8000
```

Then open: `http://localhost:8000`

---

## Option 4: Upload to Hostinger NOW (FASTEST) ✅

Since you have all the files ready, you can test directly on Hostinger:

1. **Upload files via FTP:**
   - Use FileZilla or Hostinger FTP
   - Upload the updated files:
     - `contact-handler.php` (most important)
     - `contact.html` (updated)
     - `js/components.js`
     - `css/styles.css`
     - `.htaccess`

2. **Test on live site:**
   - Go to `https://softwaresconsultants.com/contact`
   - Fill out and submit the form
   - It should work immediately!

---

## Quick Test - PHP Built-in Server

**Complete Commands (Windows):**

```bash
# Open Command Prompt (Win + R, type CMD)

# Go to your project folder (copy-paste your path)
cd "e:\Software Consultants\Qais bahudur --\softwareconsultantswebsite\software_consultants (3)\software_consultants"

# Start PHP server
php -S localhost:8000

# Output should show:
# [Mon Apr 02 10:00:00 2026] PHP 8.0.0 Development Server started at http://localhost:8000
```

**Then open browser:**
- `http://localhost:8000` → Homepage
- `http://localhost:8000/contact` → Contact form

---

## Testing the Contact Form

1. Open `http://localhost:8000/contact`
2. Fill out the form:
   - First Name: `Test`
   - Last Name: `User`
   - Email: `your-email@gmail.com`
   - Service: Select any service
   - Message: `This is a test message`
3. Click "Submit Inquiry"
4. You should see success message
5. Check your email for the inquiry

---

## If Form Still Shows "Network Error"

**Check:**
1. ✅ Server is running (PHP, XAMPP, etc.)
2. ✅ You're accessing HTTP (not file://)
3. ✅ Browser console doesn't show CORS errors
4. ✅ PHP version is 7.4 or higher

**Debug:**
1. Open Browser Developer Tools (F12)
2. Go to "Network" tab
3. Submit form
4. Look for the POST request to `contact-handler.php`
5. Check the Response tab for any PHP errors

---

## Recommended: Use VS Code Live Server Extension

**Easiest Method:**

1. Install "Live Server" extension in VS Code
   - Click Extensions (Ctrl+Shift+X)
   - Search "Live Server"
   - Click Install

2. Right-click `contact.html` → "Open with Live Server"

3. It automatically opens `http://localhost:5500`

4. Form should now work!

⚠️ **Note:** Live Server doesn't run PHP by default
- Need to use PHP server option above OR
- Upload to Hostinger to fully test SMTP

---

## Why Testing Locally Matters

| Issue | Cause | Solution |
|-------|-------|----------|
| Network error | file:// protocol | Use PHP/Node server |
| CORS error | Browser security | Use http:// or https:// |
| PHP not executing | File opened directly | Run on web server |
| Form not submitting | No server | Upload to Hostinger |

---

## SMTP Testing

**Important:** You can only test SMTP when:
1. Running on a real web server (Hostinger, not localhost)
2. OR using Hostinger's actual SMTP details (which you've configured)

**For localhost testing:**
- Form validation will work
- Error handling will work
- SMTP will fail (expected!) because localhost doesn't have email setup
- Go live on Hostinger to test full email sending

---

## Troubleshooting

**Q: I started PHP server but can't access it**
A: Make sure you're in the correct directory and PHP is in your PATH:
```bash
# Check PHP is installed
php --version

# Make sure you're in project folder
cd "your/project/path"

# Try using full path
php -S 127.0.0.1:8000
```

**Q: Form still not working on localhost**
A: SMTP won't work on localhost because:
- Hostinger SMTP is for live server only
- But form validation WILL work
- Upload to Hostinger to send real emails

**Q: Can I use Live Server for SMTP testing?**
A: No, Live Server doesn't run PHP
- Use PHP built-in server or XAMPP
- Or upload to Hostinger immediately

**Q: Port 8000 already in use?**
A: Use different port:
```bash
php -S localhost:8001
php -S localhost:9000
# Then open http://localhost:8001
```

---

## Summary

| Server Type | Setup Time | Can Test Form | Can Test SMTP |
|------------|-----------|---------------|---------------|
| **PHP Built-in** | 2 min | ✅ Yes | ❌ No |
| **XAMPP** | 5 min | ✅ Yes | ❌ No |
| **Live Server** | 1 min | ⚠️ Partial | ❌ No |
| **Hostinger Live** | Upload | ✅ Yes | ✅ Yes |

**Recommendation:** Use PHP built-in server for quick testing, then upload to Hostinger for full testing with SMTP!

---

**Quick Start - One Command:**
```bash
cd "e:\Software Consultants\Qais bahudur --\softwareconsultantswebsite\software_consultants (3)\software_consultants" && php -S localhost:8000
```

Then open: `http://localhost:8000/contact`

