#!/bin/bash

set -e

env=${APP_ENV:-production}
role=${CONTAINER_ROLE:-fpm}

if [[ "$env" == "dev" ]]; then

    (composer install --no-interaction)

else

    (
        composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev \
        && php artisan optimize
    )

fi

(
    php artisan storage:link \
    & chown -R www-data:www-data . \
    && chmod -R 755 storage \
    && chmod -R 755 bootstrap/ \
    && php artisan migrate --force
)

if [[ "$role" == "queue" ]]; then

    exec php /app/artisan queue:work --verbose --tries=3 --timeout=90

elif [[ "$role" == "fpm" ]]; then

    exec php-fpm

fi
