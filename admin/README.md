# Apollo CMS - Content Management System

## 🎯 Overview

A password-protected admin panel for managing all content on the Apollo website, including:
- **Projects** (homepage featured projects)
- **Videos** (short previews, full videos, embedded URLs)
- **Thumbnails** (preview images)
- **Artists** (roster information)
- **Credits** (project credits with HTML formatting)
- **Settings** (site-wide settings)

## 🔐 Login

**Default Credentials:**
- Username: `admin`
- Password: `apollo2024!`

**⚠️ IMPORTANT:** Change the password in `config.php` after first login!

## 📁 Structure

```
admin/
├── config.php              # Configuration & authentication
├── login.php               # Login page
├── index.php               # Dashboard
├── projects.php            # Manage homepage projects
├── artists.php             # Manage artists/roster
├── videos.php              # Video library management
├── settings.php            # Site settings
├── sync.php                # Sync CMS data to website files
├── logout.php              # Logout handler
├── sidebar.php             # Navigation sidebar
├── style.css               # Admin panel styles
└── templates/
    └── index_template.php   # Template for generating index.php
```

## 🚀 Usage

1. **Access Admin Panel:**
   - Navigate to: `http://localhost:8000/admin/`
   - Login with default credentials

2. **Add/Edit Projects:**
   - Go to "Projects" in sidebar
   - Click "Add Project" or edit existing
   - Fill in all project details:
     - Title, Subtitle
     - Category (Edit/Color/Sound/VFX)
     - Short video (preview)
     - Long video (full/embedded)
     - Preview images (up to 6)
     - Credits (HTML allowed)

3. **Sync to Website:**
   - After making changes, go to "Sync to Website"
   - Click "Sync Now" to update `index.php` with your changes
   - Your changes will be live on the website!

## 📊 Data Storage

All content is stored in JSON files in `/data/`:
- `projects.json` - All homepage projects
- `artists.json` - Artist/roster information
- `settings.json` - Site settings

## 🔄 Workflow

1. **Develop Branch:** Work on `develop` branch for all changes
2. **Edit Content:** Use admin panel to manage content
3. **Sync:** Generate website files from CMS data
4. **Test:** View changes on local server
5. **Commit:** Commit changes to develop branch
6. **Merge:** Merge to main when ready

## 🛠️ Features

- ✅ Password-protected admin panel
- ✅ Beautiful, modern UI
- ✅ Project management (add, edit, delete, reorder)
- ✅ Video link management
- ✅ Thumbnail/preview image management
- ✅ Credits with HTML support
- ✅ Auto-sync to website files
- ✅ JSON-based storage (easy to backup/migrate)

## 🔒 Security

- Change default password in `config.php`
- Admin panel uses PHP sessions
- All user input is sanitized
- Password hashing with PHP's `password_hash()`

## 📝 Next Steps

- [ ] Add file upload for videos/thumbnails
- [ ] Add artist management page
- [ ] Add video library management
- [ ] Add settings page
- [ ] Add backup/restore functionality
- [ ] Add version history
