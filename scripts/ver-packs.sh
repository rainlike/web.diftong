#!/usr/bin/env bash

COLOR=`tput setaf 11`
COLORLESS=`tput sgr0`

echo "${COLOR}NPM/YARN >>>>>>>>>>>>>>>>>>>>>>>>>${COLORLESS}"
npm ls
npm outdated
echo "${COLOR}^^^^^^^^^^^^^^^^^^^^^^^^^ NPM$/Yarn{COLORLESS}"

echo "${COLOR}COMPOSER >>>>>>>>>>>>>>>>>>>>>>>>>${COLORLESS}"
composer show
composer outdated
echo "${COLOR}^^^^^^^^^^^^^^^^^^^^^^^^^ COMPOSER${COLORLESS}"
