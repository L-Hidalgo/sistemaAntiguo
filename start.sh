#!/bin/sh
set -eu

ENV_FILE=".env"

composer install

npm install

php artisan serve --host 0.0.0.0
