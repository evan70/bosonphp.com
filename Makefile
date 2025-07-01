
up:
	docker compose up --build -d

down:
	docker compose down

php:
	docker exec -it phpdoc-php bash

php-root:
	docker exec -it -uroot phpdoc-php bash

node:
	docker exec -it -u1000 phpdoc-node sh

angie:
	docker exec -it phpdoc-angie sh

angie-root:
	docker exec -it -uroot phpdoc-angie sh

deploy: build push

build:
	docker compose --profile build build

push:
	docker compose --profile build push
