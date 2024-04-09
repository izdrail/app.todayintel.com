#!/bin/sh
dev:
	cp .env.example .env && ./vendor/bin/sail build --no-cache --progress=plain
production:
	cp .env.production .env && ./vendor/bin/sail build --no-cache --progress=plain
up:
	docker-compose up
down:
	docker-compose down
restart-horizon:
	docker exec -it app.todayintel.com supervisorctl restart laravel-horizon:*
push:
	docker push saturnphp/app.todayintel.com:latest
watch:
	npm run watch
frontend:
	npm run production
ssh:
	sail bash
