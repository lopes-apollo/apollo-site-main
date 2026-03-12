#!/bin/bash
export PATH="/opt/homebrew/bin:$PATH"
cd /Users/lopes/Desktop/APOLLO/apollo-site-main
gh repo create apollo-site --public --source=. --remote=origin --push
