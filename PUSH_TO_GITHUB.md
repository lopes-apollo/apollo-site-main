# How to Push Code to GitHub - Step by Step

## 🚀 Complete Guide

### **Step 1: Install Git (if needed)**

Check if Git is installed:
```bash
git --version
```

If not installed, install it:
```bash
brew install git
```

---

### **Step 2: Initialize Git Repository**

In your project folder, run:
```bash
cd /Users/lopes/Desktop/APOLLO/apollo-site-main
git init
```

This creates a Git repository in your folder.

---

### **Step 3: Add All Files**

Add all your files to Git:
```bash
git add .
```

This stages all files for commit.

---

### **Step 4: Create First Commit**

Commit your files:
```bash
git commit -m "Initial Apollo website commit"
```

This saves a snapshot of your code.

---

### **Step 5: Create GitHub Repository**

1. Go to https://github.com
2. Sign up (or log in if you have an account)
3. Click the **"+"** icon in top right
4. Click **"New repository"**
5. Fill in:
   - **Repository name**: `apollo-site` (or any name you want)
   - **Description**: "Apollo Post Production Website" (optional)
   - **Visibility**: Choose Public or Private
   - **DO NOT** check "Initialize with README" (you already have files)
6. Click **"Create repository"**

---

### **Step 6: Connect Local Repository to GitHub**

GitHub will show you commands. Use these:

```bash
# Add GitHub as remote (replace YOUR_USERNAME with your GitHub username)
git remote add origin https://github.com/YOUR_USERNAME/apollo-site.git

# Rename branch to main (if needed)
git branch -M main

# Push to GitHub
git push -u origin main
```

**Note:** You'll be asked for your GitHub username and password (or token).

---

### **Step 7: Authentication**

If asked for credentials:
- **Username**: Your GitHub username
- **Password**: Use a **Personal Access Token** (not your GitHub password)

**To create a Personal Access Token:**
1. GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Click "Generate new token"
3. Give it a name (e.g., "Apollo Website")
4. Select scopes: Check "repo"
5. Click "Generate token"
6. **Copy the token** (you won't see it again!)
7. Use this token as your password when pushing

---

## 🎯 **Quick Command Summary**

Copy and paste these commands one at a time:

```bash
# Navigate to project
cd /Users/lopes/Desktop/APOLLO/apollo-site-main

# Initialize Git
git init

# Add all files
git add .

# Create commit
git commit -m "Initial Apollo website commit"

# Add GitHub remote (REPLACE YOUR_USERNAME)
git remote add origin https://github.com/YOUR_USERNAME/apollo-site.git

# Push to GitHub
git branch -M main
git push -u origin main
```

---

## ✅ **After Pushing**

Once pushed, you can:
- View your code on GitHub.com
- Edit in Cursor locally
- Push changes with: `git add . && git commit -m "message" && git push`
- Deploy to Render/Railway (they'll connect to your GitHub)

---

## 🔄 **Future Updates**

After initial push, to update GitHub:

```bash
git add .
git commit -m "Description of changes"
git push
```

That's it! Your changes will be on GitHub.

---

## 🆘 **Troubleshooting**

### "Repository not found"
- Check your GitHub username is correct
- Make sure repository exists on GitHub
- Verify you have access to the repository

### "Authentication failed"
- Use Personal Access Token instead of password
- Make sure token has "repo" scope

### "Nothing to commit"
- Make sure you're in the right directory
- Check if files are already committed: `git status`

---

## 📝 **Need Help?**

If you get stuck, share the error message and I'll help you fix it!
