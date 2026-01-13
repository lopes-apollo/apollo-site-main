# Installation Instructions

## Quick Installation (Recommended)

### Step 1: Install Homebrew

Open Terminal and run:
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

Follow the on-screen instructions. This will install Homebrew, which is a package manager for macOS.

**Note:** After installation, you may need to add Homebrew to your PATH. The installer will tell you the exact commands, but typically it's:
```bash
echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zprofile
eval "$(/opt/homebrew/bin/brew shellenv)"
```

### Step 2: Install PHP

Once Homebrew is installed, run:
```bash
brew install php
```

This will install the latest version of PHP.

### Step 3: Verify Installation

Check that PHP is installed:
```bash
php --version
```

You should see something like:
```
PHP 8.3.x (cli) ...
```

### Step 4: Start the Server

Navigate to the project directory:
```bash
cd /Users/lopes/Desktop/APOLLO/apollo-site-main
```

Then start the server:
```bash
./start-server.sh
```

Or manually:
```bash
php -S localhost:8000
```

### Step 5: Open in Browser

Open your web browser and go to:
```
http://localhost:8000
```

---

## Alternative: Using MAMP (Easier GUI Option)

If you prefer a graphical interface:

1. Download MAMP from: https://www.mamp.info/
2. Install MAMP
3. Open MAMP and click "Start Servers"
4. Copy your project to: `/Applications/MAMP/htdocs/apollo-site-main`
5. Access at: `http://localhost:8888/apollo-site-main`

---

## Troubleshooting

### "Command not found" errors
- Make sure Homebrew is in your PATH
- Try restarting Terminal
- Run: `eval "$(/opt/homebrew/bin/brew shellenv)"`

### Port already in use
- Use a different port: `php -S localhost:8001`
- Or find what's using port 8000: `lsof -i :8000`

### Permission denied on scripts
- Make scripts executable: `chmod +x start-server.sh install-php.sh`

---

## What's Next?

Once the server is running:
- ✅ Homepage: http://localhost:8000
- ✅ Roster: http://localhost:8000/work/
- ✅ Contact: http://localhost:8000/contact/
- ✅ Individual pages: http://localhost:8000/roster/[artist-name]
