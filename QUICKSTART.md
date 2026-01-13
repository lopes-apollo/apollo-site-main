# Quick Start Guide

## 🚀 Get Started in 3 Steps

### Step 1: Install PHP

**If you have Homebrew:**
```bash
brew install php
```

**If you don't have Homebrew:**
1. Install Homebrew: https://brew.sh
2. Then run: `brew install php`

**Alternative:** Download MAMP (macOS) or XAMPP from their websites

### Step 2: Start the Server

**Option A - Use the startup script (easiest):**
```bash
./start-server.sh
```

**Option B - Manual start:**
```bash
php -S localhost:8000
```

### Step 3: Open in Browser

Open your browser and go to:
```
http://localhost:8000
```

That's it! 🎉

---

## 📁 Project Overview

This is a portfolio website for **Apollo Post Production** featuring:
- Homepage with video showcase
- Roster/Work pages (Edit, Color, Sound, VFX)
- Individual artist pages
- Contact page

## 🔧 Troubleshooting

**"php: command not found"**
→ Install PHP using the instructions in Step 1

**"Port 8000 already in use"**
→ Use a different port: `php -S localhost:8001`

**CSS/Images not loading**
→ Make sure you're using `http://localhost:8000` (not `file://`)

For more details, see `SETUP.md`
