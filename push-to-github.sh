#!/bin/bash
# Script to push Apollo website to GitHub using GitHub CLI

set -e

REPO_NAME="apollo-site"
PROJECT_DIR="/Users/lopes/Desktop/APOLLO/apollo-site-main"

cd "$PROJECT_DIR"

echo "═══════════════════════════════════════════════════════════════"
echo "  Apollo Website - Push to GitHub using GitHub CLI"
echo "═══════════════════════════════════════════════════════════════"
echo ""

# Check if gh is installed
if ! command -v gh &> /dev/null; then
    echo "❌ GitHub CLI (gh) is not installed."
    echo ""
    echo "Please install it first:"
    echo "  brew install gh"
    echo ""
    echo "Or download from: https://cli.github.com/"
    exit 1
fi

echo "✓ GitHub CLI found: $(gh --version | head -n 1)"
echo ""

# Check if authenticated
if ! gh auth status &> /dev/null; then
    echo "🔐 You need to authenticate with GitHub first."
    echo ""
    echo "Running: gh auth login"
    echo "Follow the prompts to authenticate."
    echo ""
    gh auth login
fi

echo "✓ Authenticated with GitHub"
echo ""

# Get GitHub username
GITHUB_USER=$(gh api user -q .login)
echo "✓ GitHub username: $GITHUB_USER"
echo ""

# Check if repo already exists
if gh repo view "$GITHUB_USER/$REPO_NAME" &> /dev/null; then
    echo "✓ Repository $GITHUB_USER/$REPO_NAME already exists"
    echo ""
    # Check if remote is already set
    if git remote get-url origin &> /dev/null; then
        echo "✓ Remote 'origin' already configured"
    else
        echo "Setting up remote..."
        git remote add origin "https://github.com/$GITHUB_USER/$REPO_NAME.git"
    fi
else
    echo "Creating new repository: $GITHUB_USER/$REPO_NAME"
    echo ""
    # Create repo using gh CLI
    gh repo create "$REPO_NAME" --public --source=. --remote=origin --push
    echo ""
    echo "✓ Repository created and code pushed!"
    exit 0
fi

# Push to existing repo
echo "Pushing code to GitHub..."
echo ""

# Ensure we're on main branch
git branch -M main 2>/dev/null || true

# Push to GitHub
git push -u origin main

echo ""
echo "═══════════════════════════════════════════════════════════════"
echo "  ✅ Success! Your code is now on GitHub!"
echo "═══════════════════════════════════════════════════════════════"
echo ""
echo "Repository URL: https://github.com/$GITHUB_USER/$REPO_NAME"
echo ""
