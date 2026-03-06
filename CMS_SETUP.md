# 🎬 Apollo CMS - Complete Setup Guide

## ✅ What's Been Built

I've created a **complete password-protected admin panel** for managing your Apollo website content!

### 🎯 Features

1. **Develop Branch Setup**
   - Script ready to create `develop` branch
   - All development work happens on `develop`
   - Merge to `main` when ready for production

2. **Admin Panel** (`/admin/`)
   - Beautiful, modern UI
   - Password-protected login
   - Dashboard with statistics
   - Full navigation sidebar

3. **Content Management**
   - **Projects**: Add/edit/delete homepage projects
   - **Artists**: Manage roster/artist information
   - **Videos**: Video library (placeholder for future)
   - **Settings**: Site-wide settings

4. **Sync System**
   - Generates `index.php` from CMS data
   - Updates website files automatically
   - Preview changes before syncing

## 🚀 Getting Started

### Step 1: Create Develop Branch

Run this in your terminal:
```bash
cd /Users/lopes/Desktop/APOLLO/apollo-site-main
bash create-develop-branch.sh
```

Or manually:
```bash
git checkout -b develop
git push -u origin develop
```

### Step 2: Access Admin Panel

1. Start your PHP server:
   ```bash
   php -S localhost:8000
   ```

2. Navigate to: **http://localhost:8000/admin/**

3. Login with:
   - **Username**: `admin`
   - **Password**: `apollo2024!`

### Step 3: Change Password

**IMPORTANT:** After first login, edit `admin/config.php` and change:
```php
define('ADMIN_PASSWORD_HASH', password_hash('YOUR_NEW_PASSWORD', PASSWORD_DEFAULT));
```

## 📋 How to Use

### Managing Projects

1. Go to **Projects** in sidebar
2. Click **Add Project**
3. Fill in:
   - Title & Subtitle
   - Category (Edit/Color/Sound/VFX)
   - Short video path (preview)
   - Long video URL (full/embedded)
   - Preview images (up to 6)
   - Credits (HTML allowed)
4. Click **Save Project**

### Syncing to Website

1. After making changes, go to **Sync to Website**
2. Review the preview
3. Click **Sync Now**
4. Your `index.php` will be updated with your changes!

### Workflow

```
Develop Branch → Edit in CMS → Sync → Test → Commit → Merge to Main
```

## 📁 File Structure

```
admin/
├── config.php              # Configuration & auth
├── login.php               # Login page
├── index.php               # Dashboard
├── projects.php            # Project management ⭐
├── artists.php             # Artist management
├── videos.php              # Video library
├── settings.php            # Site settings
├── sync.php                # Sync to website ⭐
├── templates/
│   └── index_template.php  # Template for index.php
└── README.md               # Admin documentation

data/                       # JSON storage (auto-created)
├── projects.json           # All projects
├── artists.json            # All artists
└── settings.json           # Site settings
```

## 🎨 What You Can Manage

### Projects
- ✅ Title & Subtitle
- ✅ Category/Author (Edit, Color, Sound, VFX)
- ✅ Short video (preview)
- ✅ Long video (full/embedded URL)
- ✅ Preview images (up to 6)
- ✅ Credits with HTML formatting
- ✅ Display order
- ✅ Visibility toggle

### Artists
- ✅ Name
- ✅ Category
- ✅ Bio
- ✅ Profile image
- ✅ URL slug

### Settings
- ✅ Site title
- ✅ Preloader videos (desktop/mobile)

## 🔒 Security

- Password-protected admin panel
- PHP session management
- Input sanitization
- Password hashing

## 📝 Next Steps

1. **Create develop branch** (run the script)
2. **Test the admin panel** (login and explore)
3. **Add your first project** (test the workflow)
4. **Sync to website** (see your changes live)
5. **Commit to develop branch**

## 🐛 Troubleshooting

**Can't login?**
- Check `admin/config.php` for correct password hash
- Clear browser cookies/session

**Sync not working?**
- Check file permissions on `index.php`
- Ensure `data/` directory is writable

**Projects not showing?**
- Make sure projects are marked as "Visible"
- Check that you've synced after adding projects

## 💡 Tips

- Always work on `develop` branch
- Test changes locally before syncing
- Use "Sync to Website" to preview changes
- Commit frequently to develop branch
- Merge to main when ready for production

---

**Ready to start?** Run `bash create-develop-branch.sh` and navigate to `/admin/`!
