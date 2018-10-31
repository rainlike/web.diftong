#!/usr/bin/env bash

COLOR=`tput setaf 11`
COLORLESS=`tput sgr0`

echo "${COLOR}OS:${COLORLESS}"
lsb_release -a

echo "${COLOR}APACHE:${COLORLESS}"
apachectl -V

echo "${COLOR}PHP:${COLORLESS}"
php -v

echo "${COLOR}MYSQL:${COLORLESS}"
mysql -V

echo "${COLOR}DOCKER:${COLORLESS}"
docker version

echo "${COLOR}DOCKER-COMPOSE:${COLORLESS}"
docker-compose version

echo "${COLOR}SYMFONY:${COLORLESS}"
bin/console --version

echo "${COLOR}COMPOSER:${COLORLESS}"
composer -V

echo "${COLOR}PHPUNIT:${COLORLESS}"
vendor/bin/phpunit --version

echo "${COLOR}CODECEPTION:${COLORLESS}"
vendor/bin/codecept --version

echo "${COLOR}NODE.JS:${COLORLESS}"
node -v

echo "${COLOR}NPM:${COLORLESS}"
npm -v

echo "${COLOR}YARN:${COLORLESS}"
yarn -v

echo "${COLOR}WEBPACK:${COLORLESS}"
npm view webpack version

echo "${COLOR}GULP:${COLORLESS}"
npm view gulp version

echo "${COLOR}TYPESCRIPT:${COLORLESS}"
npx tsc -v

echo "${COLOR}BOOTSTRAP:${COLORLESS}"
npm view bootstrap version

echo "${COLOR}JQUERY:${COLORLESS}"
npm view jquery version

echo "${COLOR}VUE:${COLORLESS}"
npm view vue version

echo "${COLOR}BABEL:${COLORLESS}"
npm view babel-core version

echo "${COLOR}CYPRESS:${COLORLESS}"
npx cypress -v
