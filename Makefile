
#!/usr/bin/make

SHELL=/bin/bash

UID := $(shell id -u)
GID := $(shell id -g)
PWD := $(shell pwd)

export UID
export GID

.PHONY: up down docker-build composer composer-install composer-update

up:
	env UID=${UID} GID=${GID} docker compose up -d

down:
	env UID=${UID} GID=${GID} docker compose down

docker-build:
	env UID=${UID} GID=${GID} docker compose --profile dev build

composer:
	docker run -it --rm --user ${UID}:${GID} -v ${PWD}:/app -w=/app composer /bin/bash

composer-install:
	docker run -it --rm --user ${UID}:${GID} -v ${PWD}:/app -w=/app composer install

composer-update:
	docker run -it --rm --user ${UID}:${GID} -v ${PWD}:/app -w=/app composer update

install: docker-build composer-install
