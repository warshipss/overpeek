#!/usr/bin/env bash

# Pull last release from Git
git reset
git checkout .
git pull origin master

docker-compose down
docker-compose build
docker-compose up -d

# Run database migrations
docker-compose exec php php artisan migrate --force \
    && php artisan auth:clear-resets \
    && php composer.phar dump -o \
    && php artisan optimize
