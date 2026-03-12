#!/bin/bash
# Fix the remote URL and push

cd /Users/lopes/Desktop/APOLLO/apollo-site-main
export PATH="/opt/homebrew/bin:$PATH"

echo "Enter your GitHub username:"
read GITHUB_USER

if [ -z "$GITHUB_USER" ]; then
    echo "Error: Username is required"
    exit 1
fi

echo "Updating remote to: https://github.com/$GITHUB_USER/apollo-site-main.git"

# Remove the broken remote
git remote remove origin 2>/dev/null || true

# Add correct remote
git remote add origin "https://github.com/$GITHUB_USER/apollo-site-main.git"

# Verify
echo "Remote configured:"
git remote -v

# Push
echo ""
echo "Pushing code to GitHub..."
git push -u origin main

echo ""
echo "✅ Success! Your code is at: https://github.com/$GITHUB_USER/apollo-site-main"
