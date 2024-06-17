# LARAVEL CRONOS API

## README (beta)

* composer install
* copy env.example -> .env
* in .env replace 
* DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
PGADMIN_DEFAULT_EMAIL=admin@example.com
PGADMIN_DEFAULT_PASSWORD=admin

* docker compose build
* sail up
* sail artisan key:generate
* sail artisan jwt:generate
