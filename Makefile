OUT=false

# Symfony
# server
.PHONY: sym.start sym.stop
sym.start:
	bin/console server:start
sym.stop:
	bin/console server:stop
# cache
.PHONY: sym.cache.perms sym.cache.clear
sym.cache.perms:
	sudo chmod 777 -R var/cache/
	sudo chown ${USER}:www-data -R var/cache/
sym.cache.clear:
	sudo chmod 777 -R var/cache/
	sudo chown ${USER}:www-data -R var/cache/
	bin/console cache:clear --no-warmup
	sudo chmod 777 -R var/cache/
	sudo chown ${USER}:www-data -R var/cache/
# misc
.PHONY: sym.perms
sym.perms:
	sudo chmod 777 -R var/cache/ var/log/ var/sessions/
	sudo chown ${USER}:www-data -R var/cache/ var/log/ var/sessions/

# Database
.PHONY: db.rebuild
db.rebuild:
	$(MAKE) sym.cache.perms
	bin/console doctrine:database:drop --force
	bin/console doctrine:database:create
	bin/console doctrine:schema:update --force
	bin/console doctrine:fixtures:load --no-interaction
	bin/console doctrine:migrations:migrate --no-interaction
	$(MAKE) sym.cache.perms

# Tests
.PHONY: test.unit test.cover test.utility
test.unit:
	bin/phpunit
test.cover:
	bin/phpunit --configuration phpunit.coverage.xml
test.utility:
	bin/phpunit --group utility

# Linting
.PHONY: lint.all lint.js lint.vue lint.ts lint.scripts lint.style
lint.js:
ifeq (${OUT}, true)
	npx eslint --format compact --output-file var/log/eslint.log assets/**/*.js
else
	npx eslint --format codeframe assets/**/*.js
endif
lint.vue:
ifeq (${OUT}, true)
	npx eslint --config .eslintrc.vue.json --format compact --output-file var/log/eslint-vue.log assets/**/*.vue
else
	npx eslint --config .eslintrc.vue.json --format codeframe assets/**/*.vue
endif
lint.ts:
ifeq (${OUT}, true)
	npx tslint --project tsconfig.json --format msbuild --out var/log/tslint.log
else
	npx tslint --project tsconfig.json --format codeFrame
endif
lint.scripts:
	$(MAKE) lint.js
	$(MAKE) lint.vue
	$(MAKE) lint.ts
lint.style:
ifeq (${OUT}, true)
	npx stylelint "assets/styles/**/*.scss" --syntax scss > var/log/stylelint.log
else
	npx stylelint "assets/styles/**/*.scss" --syntax scss
endif
lint.all:
	$(MAKE) lint.js
	$(MAKE) lint.ts
	$(MAKE) lint.styles

# Documentation
.PHONY: doc.style
doc.style:
	npm run nucleus

# Versions
.PHONY: ver.self ver.packs
ver.self:
	./scripts/ver-self.sh
ver.packs:
	./scripts/ver-packs.sh
ver.npm:
	npx npm-check

# Updates
.PHONY: upd.self upd.back upd.front
upd.self:
	sudo composer self-update
	npm install -g npm
	sudo apt install yarn
upd.front:
	npm install -g npm
	sudo apt install yarn
	yarn upgrade
upd.back:
	sudo composer self-update
	composer update --with-dependencies
	sudo chown -R ${USER}:www-data vendor/ bin/
	$(MAKE) sym.cache

# Miscellaneous
.PHONY: misc.thanx
misc.thanx:
	composer thanks
