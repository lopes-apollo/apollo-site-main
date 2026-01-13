# Apollo Post Production Website - Setup Guide

This is a PHP-based website for Apollo Post Production company. Follow these steps to get it running locally.

## Prerequisites

You need PHP installed on your system to run this website.

## Step 1: Install PHP

### Option A: Using Homebrew (Recommended for macOS)
```bash
# Install Homebrew if you don't have it
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Install PHP
brew install php
```

### Option B: Using macOS Built-in PHP (if available)
macOS sometimes includes PHP. Check if it's available:
```bash
/usr/bin/php --version
```

### Option C: Using XAMPP/MAMP
- Download XAMPP from https://www.apachefriends.org/ (includes PHP, Apache, MySQL)
- Or download MAMP from https://www.mamp.info/ (macOS specific)

## Step 2: Verify PHP Installation

After installing PHP, verify it works:
```bash
php --version
```

You should see something like:
```
PHP 8.x.x (cli) ...
```

## Step 3: Start the PHP Development Server

Navigate to the project directory and start the built-in PHP server:

```bash
cd /Users/lopes/Desktop/APOLLO/apollo-site-main
php -S localhost:8000
```

Or if using the built-in macOS PHP:
```bash
/usr/bin/php -S localhost:8000
```

## Step 4: Access the Website

Open your web browser and navigate to:
```
http://localhost:8000
```

## Project Structure

- `/` - Main homepage (index.php)
- `/work/` - Roster/work page
- `/contact/` - Contact page
- `/roster/` - Individual roster pages
- `/home-new/` - Home page assets (CSS, videos)
- `/fonts/` - Font files and logo

## Troubleshooting

### PHP Not Found
- Make sure PHP is installed and in your PATH
- Try using the full path: `/usr/bin/php` or `/opt/homebrew/bin/php`

### Port Already in Use
- Use a different port: `php -S localhost:8001`
- Or find and kill the process using port 8000

### CSS/Images Not Loading
- Make sure you're accessing via `http://localhost:8000` (not `file://`)
- Check browser console for 404 errors
- Verify file paths in the code match your directory structure

### Video Files Not Playing
- Some video files may be large - ensure they're in the correct directories
- Check browser console for video loading errors

## Notes

- This is a static PHP site (no database required)
- All assets (images, videos, fonts) should be in their respective directories
- The site uses Bootstrap 5.3.2 and jQuery (loaded from CDN)
- Some video files reference external URLs (apollo.gosimian.com)

## Next Steps

Once the server is running:
1. Test the homepage at `http://localhost:8000`
2. Navigate to `/work/` to see the roster
3. Check `/contact/` for the contact page
4. Test individual roster pages under `/roster/`
