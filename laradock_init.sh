#!/bin/bash

export COMPOSE_INTERACTIVE_NO_CLI=1

cd ./laradock
docker-compose down

docker-compose up -d postgres redis php-worker workspace meilisearch

docker-compose exec workspace bash -c "cd /var/www && composer update && php artisan migrate && php artisan config:cache && php artisan route:cache && php artisan key:generate && php artisan storage:link && php artisan passport:install"
docker-compose exec workspace bash -c "chown laradock:laradock -R /var/www"
