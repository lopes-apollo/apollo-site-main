#!/usr/bin/env python3
import subprocess
import os
import sys

os.chdir('/Users/lopes/Desktop/APOLLO/apollo-site-main')

# Add GitHub CLI to PATH
env = os.environ.copy()
env['PATH'] = '/opt/homebrew/bin:' + env.get('PATH', '')

print("Getting GitHub username...")
try:
    result = subprocess.run(['/opt/homebrew/bin/gh', 'api', 'user', '-q', '.login'], 
                          capture_output=True, text=True, env=env, timeout=10)
    github_user = result.stdout.strip()
    if github_user:
        print(f"✓ Found GitHub username: {github_user}")
    else:
        print("Could not get username automatically. Please provide it.")
        github_user = input("GitHub username: ").strip()
except Exception as e:
    print(f"Error getting username: {e}")
    github_user = input("Please enter your GitHub username: ").strip()

if not github_user:
    print("Error: No username provided")
    sys.exit(1)

repo_url = f"https://github.com/{github_user}/apollo-site-main.git"

print(f"\nConnecting to: {repo_url}")

# Remove existing remote if any
subprocess.run(['git', 'remote', 'remove', 'origin'], 
              capture_output=True, cwd='/Users/lopes/Desktop/APOLLO/apollo-site-main')

# Add remote
result = subprocess.run(['git', 'remote', 'add', 'origin', repo_url],
                       capture_output=True, text=True, 
                       cwd='/Users/lopes/Desktop/APOLLO/apollo-site-main')
if result.returncode != 0 and 'already exists' not in result.stderr:
    print(f"Note: {result.stderr}")

# Set branch to main
subprocess.run(['git', 'branch', '-M', 'main'],
              cwd='/Users/lopes/Desktop/APOLLO/apollo-site-main')

# Push
print("\nPushing code to GitHub...")
result = subprocess.run(['git', 'push', '-u', 'origin', 'main'],
                       cwd='/Users/lopes/Desktop/APOLLO/apollo-site-main')

if result.returncode == 0:
    print(f"\n✅ Success! Your code is now on GitHub!")
    print(f"Repository: https://github.com/{github_user}/apollo-site-main")
else:
    print(f"\n❌ Push failed. Error: {result.stderr}")
    sys.exit(1)
