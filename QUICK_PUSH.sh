#!/bin/bash
# Quick push script - just run this one file!

cd /Users/lopes/Desktop/APOLLO/apollo-site-main
export PATH="/opt/homebrew/bin:$PATH"

# Try to get username automatically
GITHUB_USER=$(gh api user -q .login 2>/dev/null)

if [ -z "$GITHUB_USER" ]; then
    echo "Enter your GitHub username:"
    read GITHUB_USER
fi

echo "Connecting to: https://github.com/$GITHUB_USER/apollo-site-main.git"

# Remove old remote if exists
git remote remove origin 2>/dev/null || true

# Add remote
git remote add origin "https://github.com/$GITHUB_USER/apollo-site-main.git"

# Set branch
git branch -M main

# Push
echo "Pushing code..."
git push -u origin main

echo ""
echo "✅ Done! Your code is at: https://github.com/$GITHUB_USER/apollo-site-main"
