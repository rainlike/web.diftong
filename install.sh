#!/usr/bin/env bash

# prepare
sudo chmod +x install.sh
sudo chmod -R +x scripts/

# vendors
sudo composer install
make sym.perms

# packages
yarn install

# Database
make db.rebuild
