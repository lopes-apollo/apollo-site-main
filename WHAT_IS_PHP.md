# What is PHP?

**PHP** (PHP: Hypertext Preprocessor) is a programming language that runs on web servers to create dynamic websites.

## Simple Explanation

Think of it this way:
- **HTML/CSS** = The design and structure (like a house blueprint)
- **PHP** = The engine that makes things work (like electricity and plumbing)

## Why Your Website Needs PHP

Your Apollo website uses PHP to:
- Generate pages dynamically
- Display portfolio content
- Handle navigation between pages
- Process and display video galleries
- Show different content based on what page you're viewing

## Without PHP

Right now you're seeing a placeholder page because:
- The Python server can show static HTML files
- But it **cannot execute PHP code**
- So the actual website (index.php) won't work

## With PHP

Once PHP is installed:
- The server can execute PHP code
- Your full website will load
- Videos, galleries, and all features will work
- You'll see the real Apollo Post Production site

---

## How to Install PHP

PHP is free and safe to install. Here's how:

### Step 1: Install Homebrew (Package Manager)
Open Terminal and run:
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```
*You'll be asked for your Mac password - this is normal and safe*

### Step 2: Install PHP
After Homebrew installs, run:
```bash
brew install php
```

### Step 3: Start Your Website
```bash
cd /Users/lopes/Desktop/APOLLO/apollo-site-main
./start-server.sh
```

That's it! Your website will be running at `http://localhost:8000`

---

## Alternative: Use the All-in-One Script

I've created a script that does everything automatically:

```bash
cd /Users/lopes/Desktop/APOLLO/apollo-site-main
./install-and-start.sh
```

This will:
1. Install Homebrew (if needed)
2. Install PHP
3. Start your website server
4. Show you the URL to visit

You'll just need to enter your password when prompted (this is required for security on macOS).

---

## Is PHP Safe?

Yes! PHP is:
- ✅ Used by millions of websites (Facebook, Wikipedia, WordPress)
- ✅ Open source and free
- ✅ Standard software for web development
- ✅ Only runs on your computer locally (not on the internet)

The password prompt is just macOS asking permission to install software - this is normal security.
