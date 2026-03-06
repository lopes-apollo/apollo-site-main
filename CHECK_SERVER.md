# How to Check if PHP Server is Running

## 🔍 Method 1: Check Terminal Output

When you start the server, you should see:
```
[Mon Jan 1 12:00:00 2024] PHP 8.5.1 Development Server (http://localhost:8000) started
```

**If you see this message = Server is running ✅**
**If you don't see this = Server is NOT running ❌**

---

## 🔍 Method 2: Check in Browser

1. Open your browser
2. Go to: **http://localhost:8000**
3. **If you see your website** = Server is running ✅
4. **If you see "Can't connect" or "ERR_CONNECTION_REFUSED"** = Server is NOT running ❌

---

## 🔍 Method 3: Check Terminal Process

In Terminal, run:
```bash
lsof -i :8000
```

**If you see output** = Server is running ✅
**If you see nothing** = Server is NOT running ❌

---

## 🚀 How to Start the Server

1. **Open Terminal** (in Cursor: press `` Ctrl+` `` or Terminal → New Terminal)

2. **Navigate to your project:**
   ```bash
   cd /Users/lopes/Desktop/APOLLO/apollo-site-main
   ```

3. **Start the server:**
   ```bash
   php -S localhost:8000
   ```

4. **You should see:**
   ```
   [Date] PHP X.X.X Development Server (http://localhost:8000) started
   ```

5. **Keep the terminal window open!** (Don't close it)

---

## ⚠️ Important Notes

- **The server runs in the terminal** - you must keep that terminal window open
- **If you close the terminal** = Server stops
- **If you press Ctrl+C in terminal** = Server stops
- **The server only runs while the command is active**

---

## 🎯 Quick Test

After starting the server, try:
- **http://localhost:8000** - Should show your website
- **http://localhost:8000/test-server.html** - Should show "Server is Running!"
- **http://localhost:8000/admin/login.php** - Should show login page

---

## 🐛 Troubleshooting

**"Port 8000 already in use"**
- Another server is running on port 8000
- Use a different port: `php -S localhost:8001`

**"php: command not found"**
- PHP is not installed
- Install PHP first (see SETUP.md)

**"Connection refused"**
- Server is not running
- Start it with the command above
