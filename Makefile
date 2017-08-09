.PHONY: install

## Composer is to slow for proper auto completion. Let's use sed. (2ms instead of 200-300ms)
#COMPOSER_TARGETS := $(shell composer list --raw | sed -n 's/\([^ ]*\) *Run the.*script as defined in composer.json.*/\1/p')
COMPOSER_TARGETS := $(shell sed -n -e '/^ *"scripts"/,/^ *},/!d' -e '/"scripts"/d' -e 's/^[^"]*"\([^ ]*\)" *:.*/\1/p' composer.json | grep -v '^pre-\|^post-')

all: vendor/autoload.php

$(COMPOSER_TARGETS):
	composer run-script --timeout=0 $@

install:
	composer install

vendor/autoload.php: composer.json composer.lock
	$(MAKE) install

# Ensure all dependencies are up to date when running the dev-server
dev-server: vendor/autoload.php
