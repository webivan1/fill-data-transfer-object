up:
	docker-compose up -d --build

down:
	docker-compose down --remove-orphans

install:
	docker-compose run --rm vo-php sh -c "composer install"

test:
	docker-compose run --rm vo-php sh -c "composer test"