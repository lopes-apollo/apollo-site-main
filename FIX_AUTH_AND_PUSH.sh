#!/bin/bash
# Fix authentication and push

cd /Users/lopes/Desktop/APOLLO/apollo-site-main

echo "Clearing old git credentials..."
git credential-osxkeychain erase <<EOF
host=github.com
protocol=https
EOF

echo ""
echo "Updating remote URL..."
git remote set-url origin https://lopes-apollo@github.com/lopes-apollo/apollo-site-main.git

echo ""
echo "Current remote:"
git remote -v

echo ""
echo "Pushing code..."
echo "When prompted:"
echo "  Username: lopes-apollo"
echo "  Password: Use your Personal Access Token (not your GitHub password)"
echo ""

git push -u origin main

echo ""
echo "✅ Done! Your code is at: https://github.com/lopes-apollo/apollo-site-main"
