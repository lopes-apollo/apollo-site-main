#!/bin/bash
# Create develop branch and push to GitHub

cd /Users/lopes/Desktop/APOLLO/apollo-site-main

echo "Creating develop branch..."
git checkout -b develop

echo "Pushing develop branch to GitHub..."
git push -u origin develop

echo ""
echo "✅ Develop branch created and pushed!"
echo "You're now on the develop branch."
