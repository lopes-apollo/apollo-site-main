#!/bin/bash
# Apollo Post Production - Server Setup Script
# Run this on a fresh Ubuntu 24.04 DigitalOcean Droplet
# Usage: bash server-setup.sh

set -e

echo "================================================"
echo "  Apollo Post Production - Server Setup"
echo "================================================"
echo ""

# Update system
echo "[1/6] Updating system packages..."
apt update && apt upgrade -y

# Install Apache + PHP
echo "[2/6] Installing Apache and PHP..."
apt install -y apache2 php libapache2-mod-php php-json php-mbstring php-curl unzip

# Enable required Apache modules
echo "[3/6] Configuring Apache..."
a2enmod rewrite
a2enmod headers
a2enmod expires

# Configure Apache to allow .htaccess overrides
APACHE_CONF="/etc/apache2/apache2.conf"
if grep -q "AllowOverride None" "$APACHE_CONF"; then
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' "$APACHE_CONF"
    echo "   -> Enabled AllowOverride All for /var/www/"
fi

# Set ServerName to suppress warning
echo "ServerName localhost" >> /etc/apache2/conf-available/servername.conf
a2enconf servername

# Configure PHP for file uploads (CMS needs this)
PHP_INI=$(php -r "echo php_ini_loaded_file();")
if [ -n "$PHP_INI" ]; then
    sed -i 's/upload_max_filesize = .*/upload_max_filesize = 64M/' "$PHP_INI"
    sed -i 's/post_max_size = .*/post_max_size = 64M/' "$PHP_INI"
    sed -i 's/max_execution_time = .*/max_execution_time = 120/' "$PHP_INI"
    echo "   -> PHP configured: 64M upload limit, 120s execution time"
fi

# Set proper permissions
echo "[4/6] Setting file permissions..."
chown -R www-data:www-data /var/www/html/
find /var/www/html/ -type d -exec chmod 755 {} \;
find /var/www/html/ -type f -exec chmod 644 {} \;

# Make data directory writable for CMS
if [ -d /var/www/html/data ]; then
    chmod -R 775 /var/www/html/data/
    echo "   -> data/ directory set to writable (775)"
fi

# Recreate videos symlink if needed
if [ -d /var/www/html/roster/videos ] && [ ! -L /var/www/html/videos ]; then
    ln -sf roster/videos /var/www/html/videos
    echo "   -> videos symlink created"
fi

# Configure firewall
echo "[5/6] Configuring firewall..."
ufw allow OpenSSH
ufw allow 'Apache Full'
ufw --force enable
echo "   -> Firewall enabled (SSH + HTTP + HTTPS allowed)"

# Restart Apache
echo "[6/6] Restarting Apache..."
systemctl restart apache2
systemctl enable apache2

echo ""
echo "================================================"
echo "  Setup Complete!"
echo "================================================"
echo ""
echo "Apache is running. Your site should be accessible at:"
echo "  http://$(curl -s ifconfig.me)"
echo ""
echo "Next steps:"
echo "  1. Upload your site files to /var/www/html/"
echo "  2. Run: chown -R www-data:www-data /var/www/html/"
echo "  3. Set up Cloudflare DNS"
echo ""
