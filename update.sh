#!/bin/bash

# Git Update script
# overrites all local changes not protected by .gitignore

git fetch --all
git reset --hard origin/master