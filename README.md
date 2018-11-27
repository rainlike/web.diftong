diftong.com
===========
educational portal

commands
--------

dev server
```
make sym.start - start dev Symfony server on 8000 port
make sym.stop - stop dev server
```

assets
```
npm run build - build all assets
npm run build:prod - build all assets for production
npm run watch - build all assets and watch
npm run analyze - analyze Webpack script and save into build/ directory
npm run analyze:prod - analyze Webpack script with production mode
npm run check - current status of Npm modules
npm run serv - run Webpack dev server on port :8080
```

documentation
```
npm run nucleus - generate style documentation via Nucleus and seve it to docs/nucleus directory
make doc.style - generate style documentation through Makefile
gulp nucleus - generate styles for Nucleus guide
```

dev cache and permissions
```
make sym.cache.clear - clear dev cache
make sym.cache.perms - set free permissions on cache directory
make sym.perms - set free permissions on all dev directories
```

database
```
make db.rebuild - recreate curent db with preset fixtures
```

tests
```
make test.unit - run all unit tests by PHPUnit
make test.cover - run all unit tests by PHPUnit with coverage
make test.utility - run unit tests by PHPUnit for Utility directory
```

linting
```
make lint.js - run linting for JS files by eslint
make lint.ts - run linting for TS files by tslint
make lint.scripts - run all lint for scripts
make lint.style - run linting for SCSS files by stylelint
make lint.all - run all lints
... OUT=true - output results of linting to log file (var/log/)
```

versions
```
make ver.self - check versions of installed packages, tools and vendors
make ver.packs - check current versions of Composer and Npm packages
```

updates
```
make upd.self - update Composer, Yarn and npm
make upd.back - update Composer' vendors
make upd.front - update npm' modules via Yarn
```

miscellaneous
```
make misc.thanx - say thanks via Composer)
```

