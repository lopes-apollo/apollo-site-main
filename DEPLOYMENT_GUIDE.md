# Apollo Website - Deployment & Domain Connection Guide

## 🚀 Hosting Options for PHP Websites

### **Option 1: Traditional Web Hosting (Recommended for Beginners)**

#### **Best Providers:**
1. **SiteGround** (https://www.siteground.com)
   - ✅ Easy setup
   - ✅ PHP support
   - ✅ Free SSL certificate
   - ✅ cPanel access
   - ✅ ~$3-10/month

2. **Bluehost** (https://www.bluehost.com)
   - ✅ Popular and reliable
   - ✅ One-click WordPress (if needed later)
   - ✅ Free domain for first year
   - ✅ ~$3-8/month

3. **HostGator** (https://www.hostgator.com)
   - ✅ Good for beginners
   - ✅ 24/7 support
   - ✅ ~$3-6/month

#### **How to Deploy:**
1. Sign up for hosting
2. Get FTP credentials from hosting panel
3. Upload all files via FTP (FileZilla, Cyberduck, or Cursor's FTP extension)
4. Point domain to hosting nameservers

---

### **Option 2: Modern Cloud Hosting (Best for Editing in Cursor)**

#### **A. Vercel (with PHP Runtime)**
- ✅ **Git-based deployment** (edit in Cursor, push to Git, auto-deploys)
- ✅ Free tier available
- ✅ Automatic SSL
- ⚠️ Requires PHP runtime configuration

#### **B. Netlify (with PHP support)**
- ✅ Git integration
- ✅ Drag-and-drop deployment
- ✅ Free tier
- ⚠️ Limited PHP support (may need workarounds)

#### **C. Railway** (https://railway.app)
- ✅ **Perfect for PHP**
- ✅ Git-based deployment
- ✅ Easy domain connection
- ✅ Free tier + pay-as-you-go
- ✅ **Can edit directly via Git**

#### **D. Render** (https://render.com)
- ✅ **Excellent PHP support**
- ✅ Git-based deployment
- ✅ Free tier available
- ✅ Automatic SSL
- ✅ **Edit in Cursor → Push to Git → Auto-deploys**

---

### **Option 3: VPS (Virtual Private Server) - Advanced**

#### **Providers:**
- **DigitalOcean** (https://www.digitalocean.com)
- **Linode** (https://www.linode.com)
- **AWS Lightsail** (https://aws.amazon.com/lightsail)

**Pros:**
- Full control
- Can set up Git for editing
- More flexible

**Cons:**
- Requires server management knowledge
- More setup required

---

## 🎯 **RECOMMENDED: Render.com (Best Balance)**

### Why Render?
- ✅ **Git Integration** - Edit in Cursor, push to Git, auto-deploys
- ✅ **PHP Support** - Native PHP support
- ✅ **Free Tier** - Good for testing
- ✅ **Easy Domain Setup** - Simple DNS configuration
- ✅ **Automatic SSL** - HTTPS included
- ✅ **No Server Management** - Fully managed

### Setup Steps:

1. **Create Git Repository**
   ```bash
   cd /Users/lopes/Desktop/APOLLO/apollo-site-main
   git init
   git add .
   git commit -m "Initial commit"
   ```

2. **Push to GitHub/GitLab**
   - Create account on GitHub.com
   - Create new repository
   - Push your code:
   ```bash
   git remote add origin https://github.com/yourusername/apollo-site.git
   git push -u origin main
   ```

3. **Deploy on Render**
   - Sign up at render.com
   - Click "New" → "Web Service"
   - Connect your GitHub repository
   - Settings:
     - **Build Command**: (leave empty or `echo "No build needed"`)
     - **Start Command**: `php -S 0.0.0.0:$PORT`
     - **Environment**: PHP
   - Click "Create Web Service"

4. **Connect Domain**
   - In Render dashboard, go to your service
   - Click "Custom Domains"
   - Add your domain
   - Update DNS records (Render will show you what to add)

---

## 🔗 **Connecting Your Domain**

### **Step 1: Get Your Domain**
- Purchase from: Namecheap, GoDaddy, Google Domains, etc.

### **Step 2: Update DNS Records**

#### **For Render/Railway/Modern Hosting:**
1. Go to your domain registrar's DNS settings
2. Add/Update these records:

**Option A: CNAME (Easiest)**
```
Type: CNAME
Name: @ (or www)
Value: your-app.onrender.com
TTL: 3600
```

**Option B: A Record (If CNAME not supported)**
```
Type: A
Name: @
Value: [IP address from hosting provider]
TTL: 3600
```

#### **For Traditional Hosting (SiteGround, Bluehost, etc.):**
1. Get nameservers from your hosting provider
2. Update nameservers at your domain registrar:
   ```
   ns1.yourhost.com
   ns2.yourhost.com
   ```

### **Step 3: Wait for DNS Propagation**
- Usually takes 24-48 hours (can be faster)
- Check with: https://www.whatsmydns.net

---

## ✏️ **Editing in Cursor After Deployment**

### **Method 1: Git-Based Workflow (Recommended)**

**Setup:**
1. Keep your code in Git (GitHub/GitLab)
2. Edit files in Cursor locally
3. Push changes to Git
4. Hosting auto-deploys

**Workflow:**
```bash
# Make changes in Cursor
# Then in terminal:
git add .
git commit -m "Updated homepage"
git push
# Hosting automatically deploys!
```

### **Method 2: Direct FTP Editing**

**For Traditional Hosting:**
1. Install FTP extension in Cursor
2. Connect to hosting via FTP
3. Edit files directly
4. Save = live update

**Extensions:**
- "FTP-Sync" for Cursor/VS Code
- "SFTP" extension

### **Method 3: SSH/SFTP Access**

**For VPS:**
1. Set up SSH access
2. Use Cursor's remote SSH feature
3. Edit files directly on server

---

## 📋 **Quick Setup Checklist**

### **For Git-Based Hosting (Render/Railway):**

- [ ] Create GitHub account
- [ ] Initialize Git in project folder
- [ ] Push code to GitHub
- [ ] Sign up for hosting (Render/Railway)
- [ ] Connect GitHub repository
- [ ] Configure PHP runtime
- [ ] Add custom domain
- [ ] Update DNS records
- [ ] Wait for DNS propagation
- [ ] Test website on your domain

### **For Traditional Hosting:**

- [ ] Sign up for hosting
- [ ] Get FTP credentials
- [ ] Upload files via FTP
- [ ] Get nameservers from host
- [ ] Update nameservers at domain registrar
- [ ] Wait for DNS propagation
- [ ] Test website

---

## 🔧 **Important Files to Check Before Deploying**

1. **Update Paths** - Make sure all paths are relative or use absolute paths
2. **Environment Variables** - If any (this site doesn't use any)
3. **PHP Version** - Ensure hosting supports PHP 8.x
4. **File Permissions** - Usually 644 for files, 755 for directories

---

## 💡 **Pro Tips**

1. **Use Git** - Even if not using Git-based hosting, use Git for version control
2. **Test Locally First** - Always test changes locally before deploying
3. **Backup** - Keep backups of your files
4. **SSL Certificate** - Most modern hosts provide free SSL (HTTPS)
5. **CDN** - Consider Cloudflare for faster loading (free tier available)

---

## 🆘 **Troubleshooting**

### **Domain Not Working?**
- Check DNS propagation: https://www.whatsmydns.net
- Verify DNS records are correct
- Wait 24-48 hours for full propagation

### **PHP Errors?**
- Check PHP version (needs 7.4+)
- Check file permissions
- Check error logs in hosting panel

### **Files Not Loading?**
- Verify file paths are correct
- Check .htaccess file (if using Apache)
- Ensure all files uploaded correctly

---

## 📞 **Next Steps**

1. **Choose your hosting** (I recommend Render for Git integration)
2. **Set up Git repository** (if using Git-based hosting)
3. **Deploy your site**
4. **Connect your domain**
5. **Start editing in Cursor!**

Need help with any specific step? Let me know!
