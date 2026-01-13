#!/bin/bash

# Setup Git Repository for Apollo Website
# This script helps you set up Git for deployment

echo "═══════════════════════════════════════════════════════════════"
echo "  Apollo Website - Git Setup"
echo "═══════════════════════════════════════════════════════════════"
echo ""

# Check if Git is installed
if ! command -v git &> /dev/null; then
    echo "✗ Git is not installed"
    echo ""
    echo "Install Git:"
    echo "  brew install git"
    echo ""
    exit 1
fi

echo "✓ Git is installed: $(git --version)"
echo ""

# Get the directory where this script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

# Check if already a git repository
if [ -d ".git" ]; then
    echo "⚠ Git repository already exists"
    echo ""
    read -p "Do you want to reinitialize? (y/n): " -n 1 -r
    echo ""
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        rm -rf .git
        echo "✓ Removed existing Git repository"
    else
        echo "Keeping existing repository"
        exit 0
    fi
fi

# Initialize Git
echo "Initializing Git repository..."
git init
echo "✓ Git repository initialized"
echo ""

# Add all files
echo "Adding files to Git..."
git add .
echo "✓ Files added"
echo ""

# Create initial commit
echo "Creating initial commit..."
git commit -m "Initial Apollo website commit"
echo "✓ Initial commit created"
echo ""

echo "═══════════════════════════════════════════════════════════════"
echo "  Next Steps"
echo "═══════════════════════════════════════════════════════════════"
echo ""
echo "1. Create a GitHub account: https://github.com"
echo ""
echo "2. Create a new repository on GitHub"
echo ""
echo "3. Connect your local repository:"
echo "   git remote add origin https://github.com/YOUR_USERNAME/REPO_NAME.git"
echo "   git branch -M main"
echo "   git push -u origin main"
echo ""
echo "4. Deploy to Render/Railway and connect your domain"
echo ""
echo "See DEPLOYMENT_GUIDE.md for detailed instructions"
echo "═══════════════════════════════════════════════════════════════"
