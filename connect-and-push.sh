#!/bin/bash
cd /Users/lopes/Desktop/APOLLO/apollo-site-main && export PATH="/opt/homebrew/bin:$PATH" && GITHUB_USER=$(gh api user -q .login) && git remote remove origin 2>/dev/null; git remote add origin "https://github.com/$GITHUB_USER/apollo-site-main.git" && git branch -M main && git push -u origin main && echo "✅ Success! Code pushed to https://github.com/$GITHUB_USER/apollo-site-main"
