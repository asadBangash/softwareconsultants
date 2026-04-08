# Fix for 404 Error on Hostinger - Clean URLs Not Working

## Problem
You're getting a 404 error when accessing `softwaresconsultants.com/index` (or any clean URL without .html)

## Root Causes (Most Likely)
1. `.htaccess` file has syntax errors or incorrect rewrite rules
2. `mod_rewrite` is not enabled on your Hostinger server
3. `AllowOverride` is not set correctly
4. Files weren't uploaded properly to the server

---

## ✅ STEP 1: Verify Files Are Uploaded

**Via FTP, check your Hostinger root directory contains:**
- ✅ `index.html` (file must exist!)
- ✅ `contact.html`
- ✅ `about.html`
- ✅ `contact-handler.php`
- ✅ `.htaccess` (check it's not hidden!)
- ✅ `/css/` folder with `styles.css`
- ✅ `/js/` folder with `components.js` and `main.js`
- ✅ `/services/` folder with HTML files
- ✅ `/industries/` folder with HTML files

**If any files are missing**, upload them from your local folder!

---

## ✅ STEP 2: Check/Fix .htaccess File

### Option A: Use the Simple Version (Recommended First)
1. In your local project, rename current `.htaccess` to `.htaccess-backup`
2. Rename `.htaccess-simple` to `.htaccess`
3. Upload the new `.htaccess` to Hostinger root
4. Test: Go to `https://softwaresconsultants.com/index`

### Option B: Replace .htaccess with This
If simple version doesn't work, use this on Hostinger:

**Upload a new `.htaccess` with:**
```
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Don't rewrite real files/directories
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

# Remove .html from display (rewrite to .html)
RewriteRule ^([a-zA-Z0-9_-]+)/?$ $1.html [L]
RewriteRule ^([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)/?$ $1/$2.html [L]

# 301 redirect from .html to clean URL
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /([a-zA-Z0-9_-]+)\.html [NC]
RewriteRule ^([a-zA-Z0-9_-]+)\.html$ /$1 [R=301,L]

</IfModule>

Options -Indexes
```

---

## ✅ STEP 3: Contact Hostinger Support

If it still doesn't work, Hostinger support can help:

**Ask them:**
> "I need to enable clean URLs using .htaccess rewrite. Please confirm:
> 1. mod_rewrite is enabled
> 2. AllowOverride is set to All (not None)
> 3. My account supports .htaccess files"

They'll respond within hours.

---

## ✅ STEP 4: Create Test File (Debug)

**Upload a test file** `test-rewrite.php`:
```php
<?php
echo "Rewrite is working!";
echo "<br>REQUEST_URI: " . $_SERVER['REQUEST_URI'];
echo "<br>REQUEST_FILENAME: " . $_SERVER['REQUEST_FILENAME'];
echo "<br>SERVER_NAME: " . $_SERVER['SERVER_NAME'];
?>
```

1. Upload to Hostinger root
2. Visit: `https://softwaresconsultants.com/test-rewrite.php`
3. If you see content → rewrite might be working
4. Check what REQUEST_URI shows

---

## ✅ STEP 5: Temporary Workaround

**While debugging**, access pages with .html:
- `https://softwaresconsultants.com/index.html` ← Should work
- `https://softwaresconsultants.com/contact.html` ← Should work
- `https://softwaresconsultants.com/about.html` ← Should work

If THESE work, then .html files are there but rewrite isn't working.

---

## ✅ STEP 6: Check Hostinger Control Panel

1. **Log into Hostinger hPanel**
2. Go to **Files → File Manager**
3. Navigate to public root directory
4. Look for `.htaccess` file - it might be hidden:
   - Right side: Settings (⚙️) → Show Hidden Files
5. Click `.htaccess` and check contents are correct
6. If it exists with wrong content, delete and upload new one

---

## Recommended Action Plan

1. **First:** Verify all `.html` files work directly
   - Test: `https://softwaresconsultants.com/index.html`
   - If this fails → files aren't uploaded properly

2. **Second:** Upload `.htaccess-simple` version
   - Rename current `.htaccess` to `.htaccess-old` on server
   - Upload new simple version
   - Test clean URL

3. **Third:** Contact Hostinger if still failing
   - Ask about mod_rewrite and AllowOverride settings
   - They can enable if needed

4. **Fourth:** Use .html URLs as temporary solution
   - While supporting clean URLs still works behind the scenes

---

## What Should Work After Fix

| Before | After |
|--------|-------|
| ❌ `/index` → 404 | ✅ `/index` → Works |
| ✅ `/index.html` → Works | ✅ `/index.html` → Redirects to `/index` |
| ❌ `/about` → 404 | ✅ `/about` → Works |
| ✅ `/contact.html` → Works | ✅ `/contact.html` → Redirects to `/contact` |

---

## Contact Form Note

The contact form should work either way because:
- ✅ PHP files work with or without clean URLs
- ✅ Contact form submits to `contact-handler.php` directly
- ✅ SMTP emails don't depend on .htaccess

If contact form isn't working, that's a separate SMTP issue.

---

## Quick Checklist Before Contacting Support

- [ ] `.html` files load when accessed directly (with .html)
- [ ] `.htaccess` file exists in root directory
- [ ] `.htaccess` file size is > 0 (not empty)
- [ ] You can edit `.htaccess` in File Manager
- [ ] No special characters in `.htaccess`
- [ ] No Windows line endings (use Unix/Linux format)

---

## Commands for FTP/SSH (If you have SSH access)

```bash
# SSH into server
ssh your_username@softwaresconsultants.com

# Go to public directory
cd public_html

# List hidden files
ls -la

# Check if .htaccess exists
cat .htaccess

# Check if mod_rewrite is loaded
apache2ctl -M | grep rewrite

# Fix line endings if needed
dos2unix .htaccess
```

---

## Next Steps

1. **Try uploading the simple .htaccess version first**
2. **Test with clean URLs**
3. **If still failing, contact Hostinger with info above**
4. **Once fixed, all clean URLs will work automatically**

The good news: The HTML structure and contact form are perfect. This is just a server configuration issue!

