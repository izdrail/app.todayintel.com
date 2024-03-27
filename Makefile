#!/bin/sh
dev:
	cp .env.example .env && ./vendor/bin/sail build --no-cache --progress=plain
production:
	cp .env.production .env && ./vendor/bin/sail build --no-cache --progress=plain
up:
	docker-compose up -d
stop:
	docker-compose down
restart-horizon:
	docker exec -it app_server supervisorctl restart laravel-horizon:*
push:
	docker push saturnphp/app.todayintel.com:latest
watch:
	npm run watch
frontend:
	npm run production
