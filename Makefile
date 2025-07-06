
up:
	docker compose up --build -d

down:
	docker compose down

php:
	docker exec -it boson-php bash

php-root:
	docker exec -it -uroot boson-php bash

node:
	docker exec -it -u1000 boson-node sh

angie:
	docker exec -it boson-angie sh

angie-root:
	docker exec -it -uroot boson-angie sh

deploy: build push

build:
	docker compose --profile build build

push:
	docker compose --profile build push
