DOCKER_COMPOSE = docker compose -f ./docker-compose.yml
DOCKER_COMPOSE_APP = $(DOCKER_COMPOSE) exec -u www-data app
DOCKER_COMPOSE_SERVER = $(DOCKER_COMPOSE) exec -u www-data server
DOCKER_COMPOSE_DB = $(DOCKER_COMPOSE) exec db

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

app-bash:
	$(DOCKER_COMPOSE_APP) bash

server-bash:
	$(DOCKER_COMPOSE_SERVER) bash

db-bash:
	$(DOCKER_COMPOSE_DB) bash

db-shell:
	$(DOCKER_COMPOSE_DB) mysql -u root -p

composer-install:
	$(DOCKER_COMPOSE_APP) composer install

composer-autoload:
	$(DOCKER_COMPOSE_APP) composer dump-autoload

command:
	$(DOCKER_COMPOSE_APP) php command.php $(filter-out $@,$(MAKECMDGOALS))
%:
	@:

api-doc:
	$(DOCKER_COMPOSE_APP) ./vendor/bin/openapi --output swagger.json app

npm-install:
	$(DOCKER_COMPOSE_APP) npm install

install-mix:
	$(DOCKER_COMPOSE_APP) npm install laravel-mix --save-dev

mix-dev:
	$(DOCKER_COMPOSE_APP) npx mix watch

run-dev:
	$(DOCKER_COMPOSE_APP) npm run dev

run-build:
	$(DOCKER_COMPOSE_APP) npm run build