install:
	make composer-install
	make run

run:
	./vendor/bin/sail up -d

# запуск composer в докере
composer-install:
	docker run \
		--volume ${CURDIR}:/app \
		--volume ${HOME}/.config/composer:/tmp \
		--volume /etc/passwd:/etc/passwd:ro \
		--volume /etc/group:/etc/group:ro \
		--user $(shell id -u):$(shell id -g) \
		--interactive \
		--rm \
		composer composer install --ignore-platform-reqs


npm-dev:
	./vendor/bin/sail npm run dev

npm-build:
	./vendor/bin/sail npm run build
