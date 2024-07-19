#!/bin/bash

export COMPOSE_INTERACTIVE_NO_CLI=1

cp ./env_files/.env.local ./.env

cd ./laradock
docker-compose down
cp ./nginx/sites/default_local ./nginx/sites/default.conf

docker-compose up -d postgres php-worker workspace nginx

docker-compose exec workspace bash -c "cd /var/www && composer update && php artisan migrate && php artisan config:cache && php artisan route:cache && php artisan key:generate && php artisan storage:link"
docker-compose exec workspace bash -c "chown laradock:laradock -R /var/www"
