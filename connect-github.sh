#!/bin/bash
# Connect to GitHub repository and push

cd /Users/lopes/Desktop/APOLLO/apollo-site-main

# Get GitHub username
export PATH="/opt/homebrew/bin:$PATH"
GITHUB_USER=$(gh api user -q .login 2>/dev/null)

if [ -z "$GITHUB_USER" ]; then
    echo "Please enter your GitHub username:"
    read GITHUB_USER
fi

echo "Connecting to: https://github.com/$GITHUB_USER/apollo-site-main.git"

# Remove existing remote if any
git remote remove origin 2>/dev/null || true

# Add the remote
git remote add origin "https://github.com/$GITHUB_USER/apollo-site-main.git"

# Set branch to main
git branch -M main

# Push to GitHub
echo "Pushing code to GitHub..."
git push -u origin main

echo ""
echo "✅ Success! Your code is now on GitHub!"
echo "Repository: https://github.com/$GITHUB_USER/apollo-site-main"
