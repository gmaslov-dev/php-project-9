PORT ?= 8000
start:
	PHP_CLI_SERVER_WORKERS=5 php -S 0.0.0.0:$(PORT) -t public

install:
	composer install

db-init:
	./bin/init_db.php

analyse:
	php -d memory_limit=-1 vendor/bin/phpstan analyse

lint:
	composer lint

env-create:
	@if [ ! -f .env ]; then \
		cp .env.example .env && \
		echo "Файл .env создан из .env.example"; \
	else \
		echo "Файл .env уже существует."; \
	fi

help:
	@echo "make start      — запустить сервер"
	@echo "make install    — установить зависимости"
	@echo "make db-init    — инициализировать БД"
	@echo "make analyse    — статический анализ"
	@echo "make lint       — линтинг"
	@echo "make env-create — создать .env из .env.example"