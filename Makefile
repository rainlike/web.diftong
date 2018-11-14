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
.PHONY: test.unit test.utility
test.unit:
	bin/phpunit
test.utility:
	bin/phpunit --group utility

# Git
.PHONY: git.pull
git.push:
	git push

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
