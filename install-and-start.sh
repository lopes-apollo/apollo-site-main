#!/bin/bash

# Complete installation and startup script for Apollo Website
# This script will install Homebrew (if needed), PHP, and start the server

set -e  # Exit on error

echo "═══════════════════════════════════════════════════════════════"
echo "  Apollo Website - Complete Installation & Startup"
echo "═══════════════════════════════════════════════════════════════"
echo ""

# Function to check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Check for PHP first
PHP_CMD=""
if command_exists php; then
    PHP_CMD="php"
    PHP_VERSION=$(php --version | head -n 1)
    echo "✓ PHP is already installed: $PHP_VERSION"
    echo ""
elif [ -f "/opt/homebrew/bin/php" ]; then
    PHP_CMD="/opt/homebrew/bin/php"
    export PATH="/opt/homebrew/bin:$PATH"
    PHP_VERSION=$($PHP_CMD --version | head -n 1)
    echo "✓ Found PHP: $PHP_VERSION"
    echo ""
elif [ -f "/usr/local/bin/php" ]; then
    PHP_CMD="/usr/local/bin/php"
    PHP_VERSION=$($PHP_CMD --version | head -n 1)
    echo "✓ Found PHP: $PHP_VERSION"
    echo ""
else
    echo "PHP not found. Installing..."
    echo ""
    
    # Check for Homebrew
    if command_exists brew; then
        BREW_CMD="brew"
        echo "✓ Homebrew is installed"
    elif [ -f "/opt/homebrew/bin/brew" ]; then
        BREW_CMD="/opt/homebrew/bin/brew"
        export PATH="/opt/homebrew/bin:$PATH"
        echo "✓ Found Homebrew at /opt/homebrew/bin/brew"
    elif [ -f "/usr/local/bin/brew" ]; then
        BREW_CMD="/usr/local/bin/brew"
        export PATH="/usr/local/bin:$PATH"
        echo "✓ Found Homebrew at /usr/local/bin/brew"
    else
        echo "Installing Homebrew..."
        echo "You will be prompted for your password."
        echo ""
        /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
        
        # Add Homebrew to PATH
        if [ -f "/opt/homebrew/bin/brew" ]; then
            BREW_CMD="/opt/homebrew/bin/brew"
            echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zprofile
            eval "$(/opt/homebrew/bin/brew shellenv)"
        elif [ -f "/usr/local/bin/brew" ]; then
            BREW_CMD="/usr/local/bin/brew"
            echo 'eval "$(/usr/local/bin/brew shellenv)"' >> ~/.zprofile
            eval "$(/usr/local/bin/brew shellenv)"
        fi
    fi
    
    echo ""
    echo "Installing PHP via Homebrew..."
    echo "This may take a few minutes..."
    echo ""
    $BREW_CMD install php
    
    # Find PHP after installation
    if command_exists php; then
        PHP_CMD="php"
    elif [ -f "/opt/homebrew/bin/php" ]; then
        PHP_CMD="/opt/homebrew/bin/php"
        export PATH="/opt/homebrew/bin:$PATH"
    elif [ -f "/usr/local/bin/php" ]; then
        PHP_CMD="/usr/local/bin/php"
    fi
fi

if [ -z "$PHP_CMD" ]; then
    echo "✗ Failed to find or install PHP"
    echo "Please install PHP manually: brew install php"
    exit 1
fi

# Verify PHP
PHP_VERSION=$($PHP_CMD --version | head -n 1)
echo "✓ Using PHP: $PHP_VERSION"
echo ""

# Get script directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

echo "═══════════════════════════════════════════════════════════════"
echo "  Starting PHP Development Server"
echo "═══════════════════════════════════════════════════════════════"
echo ""
echo "Server directory: $SCRIPT_DIR"
echo "Server URL: http://localhost:8000"
echo ""
echo "Press Ctrl+C to stop the server"
echo "═══════════════════════════════════════════════════════════════"
echo ""

# Start the server
$PHP_CMD -S localhost:8000
