#!/bin/bash

# Apollo Website - PHP Server Startup Script
# This script helps start the PHP development server

echo "=========================================="
echo "Apollo Post Production Website"
echo "PHP Development Server Startup"
echo "=========================================="
echo ""

# Try to find PHP in common locations
PHP_CMD=""

if command -v php &> /dev/null; then
    PHP_CMD="php"
    echo "✓ Found PHP: $(which php)"
elif [ -f "/usr/bin/php" ]; then
    PHP_CMD="/usr/bin/php"
    echo "✓ Found PHP: /usr/bin/php"
elif [ -f "/opt/homebrew/bin/php" ]; then
    PHP_CMD="/opt/homebrew/bin/php"
    echo "✓ Found PHP: /opt/homebrew/bin/php"
else
    echo "✗ PHP not found!"
    echo ""
    echo "Please install PHP first:"
    echo "  Option 1: brew install php"
    echo "  Option 2: Download XAMPP or MAMP"
    echo ""
    echo "See SETUP.md for detailed instructions."
    exit 1
fi

# Get PHP version
PHP_VERSION=$($PHP_CMD --version | head -n 1)
echo "✓ PHP Version: $PHP_VERSION"
echo ""

# Get the directory where this script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

echo "Starting server in: $SCRIPT_DIR"
echo ""
echo "Server will be available at:"
echo "  http://localhost:8000"
echo ""
echo "Press Ctrl+C to stop the server"
echo "=========================================="
echo ""

# Start the PHP server
$PHP_CMD -S localhost:8000
