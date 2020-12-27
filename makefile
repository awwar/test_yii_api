Shell := /usr/bin/env bash

all:
	composer install --no-interaction
	php yii migrate --interactive=0