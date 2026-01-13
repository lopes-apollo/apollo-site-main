# Quick Deployment Guide

## 🚀 Fastest Way to Go Live

### **Step 1: Choose Hosting**

**Best Option: Render.com** (Free tier, Git-based, easy)

### **Step 2: Set Up Git** (5 minutes)

```bash
# In your project folder
cd /Users/lopes/Desktop/APOLLO/apollo-site-main

# Initialize Git
git init

# Add all files
git add .

# Create first commit
git commit -m "Initial Apollo website"
```

### **Step 3: Push to GitHub**

1. Go to https://github.com and create account
2. Create new repository (name it "apollo-site")
3. Copy the repository URL
4. Run:
```bash
git remote add origin https://github.com/YOUR_USERNAME/apollo-site.git
git branch -M main
git push -u origin main
```

### **Step 4: Deploy on Render**

1. Go to https://render.com
2. Sign up (free)
3. Click "New" → "Web Service"
4. Connect your GitHub account
5. Select your repository
6. Settings:
   - **Name**: apollo-website
   - **Environment**: PHP
   - **Build Command**: (leave empty)
   - **Start Command**: `php -S 0.0.0.0:$PORT`
7. Click "Create Web Service"
8. Wait 2-3 minutes for deployment

### **Step 5: Connect Your Domain**

1. In Render dashboard, click your service
2. Go to "Settings" → "Custom Domains"
3. Click "Add Custom Domain"
4. Enter your domain (e.g., apolloposthouse.com)
5. Render will show you DNS records to add
6. Go to your domain registrar (GoDaddy, Namecheap, etc.)
7. Add the CNAME or A record shown by Render
8. Wait 24-48 hours for DNS to propagate

### **Step 6: Edit in Cursor**

**Workflow:**
1. Edit files in Cursor (locally)
2. Save changes
3. In terminal:
   ```bash
   git add .
   git commit -m "Updated homepage"
   git push
   ```
4. Render automatically deploys your changes!

---

## 🎯 **Alternative: Traditional Hosting**

If you prefer traditional hosting (SiteGround, Bluehost):

1. **Sign up** for hosting
2. **Get FTP credentials** from hosting panel
3. **Upload files** via FTP client (FileZilla, Cyberduck)
4. **Update nameservers** at domain registrar
5. **Edit via FTP** or download → edit → upload

---

## ✅ **Recommended Setup**

**For Best Experience:**
- **Hosting**: Render.com or Railway.app
- **Version Control**: GitHub
- **Editor**: Cursor (what you're using now)
- **Workflow**: Edit locally → Git push → Auto-deploy

This gives you:
- ✅ Easy editing in Cursor
- ✅ Automatic deployments
- ✅ Version history
- ✅ Easy rollbacks if something breaks

---

Ready to deploy? Start with Step 1!
