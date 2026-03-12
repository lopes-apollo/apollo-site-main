# Apollo Post Production Website

Portfolio website for Apollo Post Production company featuring work showcases, artist rosters, and contact information.

## 🚀 Quick Start

### Prerequisites
- macOS (you're on macOS, so you're good!)
- Terminal access

### Installation (5 minutes)

1. **Open Terminal** (Press `Cmd + Space`, type "Terminal", press Enter)

2. **Install Homebrew** (package manager):
   ```bash
   /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
   ```
   Follow the prompts and enter your password when asked.

3. **Add Homebrew to PATH** (if the installer tells you to):
   ```bash
   echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zprofile
   eval "$(/opt/homebrew/bin/brew shellenv)"
   ```

4. **Install PHP**:
   ```bash
   brew install php
   ```

5. **Navigate to project and start server**:
   ```bash
   cd /Users/lopes/Desktop/APOLLO/apollo-site-main
   ./start-server.sh
   ```

6. **Open in browser**:
   ```
   http://localhost:8000
   ```

## 📁 Project Structure

```
apollo-site-main/
├── index.php              # Main homepage
├── work/                  # Roster/work listing
├── contact/               # Contact page
├── roster/                # Individual artist pages
├── home-new/              # Homepage assets (CSS, videos)
├── fonts/                 # Logo and fonts
└── start-server.sh        # Server startup script
```

## 📚 Documentation

- **RUN_ME_FIRST.txt** - Step-by-step installation commands
- **QUICKSTART.md** - Quick reference guide
- **SETUP.md** - Detailed setup instructions
- **INSTALL_INSTRUCTIONS.md** - Alternative installation methods

## 🛠️ Troubleshooting

### PHP not found
- Make sure Homebrew is installed: `brew --version`
- Make sure PHP is installed: `brew install php`
- Restart Terminal after installation

### Port 8000 in use
- Use a different port: `php -S localhost:8001`
- Or stop the other service using port 8000

### Scripts won't run
- Make executable: `chmod +x start-server.sh`

## 🎯 What's Included

- ✅ Homepage with video showcase
- ✅ Roster pages (Edit, Color, Sound, VFX)
- ✅ Individual artist portfolio pages
- ✅ Contact information
- ✅ Responsive design
- ✅ Video playback functionality

## 📝 Notes

- This is a **static PHP site** (no database required)
- Uses Bootstrap 5.3.2 and jQuery (loaded from CDN)
- Some videos reference external URLs
- All assets are included in the project

## 🆘 Need Help?

1. Check `RUN_ME_FIRST.txt` for step-by-step commands
2. See `SETUP.md` for detailed troubleshooting
3. Make sure PHP is installed: `php --version`

---

**Ready to go?** Open `RUN_ME_FIRST.txt` and follow the commands!
