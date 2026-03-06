#!/bin/bash
# Start PHP server and open admin panel

cd /Users/lopes/Desktop/APOLLO/apollo-site-main

echo "Starting PHP server on http://localhost:8000"
echo ""
echo "Admin Panel: http://localhost:8000/admin/"
echo "Login: admin / apollo2024!"
echo ""
echo "Press Ctrl+C to stop the server"
echo ""

php -S localhost:8000
