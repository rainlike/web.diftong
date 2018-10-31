OUT=false

# Symfony
# server
.PHONY: sym.serv
	bin/console server:start
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
.PHONY: sym.temp
sym.temp:
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

# Miscellaneous
.PHONY: misc.thanx
misc.thanx:
	composer thanks
