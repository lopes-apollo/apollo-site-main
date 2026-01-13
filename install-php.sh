#!/bin/bash

# Apollo Website - PHP Installation Script
# This script installs Homebrew (if needed) and PHP

echo "=========================================="
echo "Apollo Website - PHP Installation"
echo "=========================================="
echo ""

# Check if Homebrew is installed
if command -v brew &> /dev/null; then
    echo "✓ Homebrew is already installed"
    BREW_CMD="brew"
elif [ -f "/opt/homebrew/bin/brew" ]; then
    echo "✓ Found Homebrew at /opt/homebrew/bin/brew"
    BREW_CMD="/opt/homebrew/bin/brew"
    # Add to PATH for this session
    export PATH="/opt/homebrew/bin:$PATH"
elif [ -f "/usr/local/bin/brew" ]; then
    echo "✓ Found Homebrew at /usr/local/bin/brew"
    BREW_CMD="/usr/local/bin/brew"
    export PATH="/usr/local/bin:$PATH"
else
    echo "✗ Homebrew not found"
    echo ""
    echo "Installing Homebrew..."
    echo "This may take a few minutes..."
    echo ""
    
    # Install Homebrew
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    
    # Check installation result
    if [ -f "/opt/homebrew/bin/brew" ]; then
        BREW_CMD="/opt/homebrew/bin/brew"
        export PATH="/opt/homebrew/bin:$PATH"
        echo "✓ Homebrew installed successfully"
    elif [ -f "/usr/local/bin/brew" ]; then
        BREW_CMD="/usr/local/bin/brew"
        export PATH="/usr/local/bin:$PATH"
        echo "✓ Homebrew installed successfully"
    else
        echo "✗ Homebrew installation failed"
        echo "Please install Homebrew manually from: https://brew.sh"
        exit 1
    fi
fi

echo ""
echo "Installing PHP..."
echo "This may take a few minutes..."
echo ""

# Install PHP
$BREW_CMD install php

# Check if PHP was installed successfully
if command -v php &> /dev/null; then
    PHP_VERSION=$(php --version | head -n 1)
    echo ""
    echo "✓ PHP installed successfully!"
    echo "✓ $PHP_VERSION"
    echo ""
    echo "=========================================="
    echo "Installation Complete!"
    echo "=========================================="
    echo ""
    echo "You can now start the server with:"
    echo "  ./start-server.sh"
    echo ""
    echo "Or manually:"
    echo "  php -S localhost:8000"
    echo ""
else
    echo ""
    echo "✗ PHP installation may have failed"
    echo "Try running: brew install php"
    echo ""
    exit 1
fi
