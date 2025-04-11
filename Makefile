.PHONY: install build up bash setup

DC = docker compose
APP = app

build:
	@echo "Building containers..."
	$(DC) up --build -d

start:
	@echo "Starting containers..."
	$(DC) restart

bash:
	$(DC) exec $(APP) bash

install: build
	@echo "composer install"
	$(DC) exec $(APP) composer install

setup:
	@echo "Generate app key"
	$(DC) exec $(APP) php artisan key:generate

	@echo "Database Migration"
	$(DC) exec $(APP) php artisan migrate:fresh
	$(DC) exec $(APP) php artisan optimize:clear

	@echo "Seeding data"
	$(DC) exec $(APP) php artisan db:seed

	@echo "running Test"
	$(DC) exec $(APP) php artisan test --testdox

%:
	@:
