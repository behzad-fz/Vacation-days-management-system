help:
	@echo "/--- Ottonova -------------------------------------------------------/";
	@echo "build		Build the container"
	@echo "up	        Create and start containers"
	@echo "destroy		Stop and remove containers"
	@echo "status 		Shows the status of the containers"
	@echo "shell		Starting a shell in php container"
	@echo "test     	Run all the application tests"
	@echo "/-----------------------------------------------------------------/";

build:
	docker-compose up --build -d

up:
	docker-compose up -d

destroy:
	docker-compose down

status:
	docker-compose ps

shell:
	docker-compose exec app bash

test:
	./vendor/bin/phpunit