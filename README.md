# LARAVEL CRONOS API

## Table of Contents

-   [Prerequisites](#prerequisites)

## Prerequisites

Make sure you have the following prerequisites installed on your system:

-   **PHP 8.3**: The project requires PHP version 8.3 or higher.
-   **Composer**: Dependency manager for PHP.
-   **Laravel 11**: PHP framework for web artisans.
-   **Laravel Sail**: Docker development environment for Laravel.

## Installation

Follow these steps to get the project up and running on your local machine.

1.  Clone the repository:

    ```bash
    git clone https://github.com/yourusername/xxx
    cd xxx
    ```

2.  Install dependencies using Composer:

    ```bash
    composer install
    ```

3.  Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

4.  Replace the following lines in the `.env` file:

    ```env
    DB_CONNECTION=pgsql
    DB_HOST=pgsql
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password
    PGADMIN_DEFAULT_EMAIL=admin@example.com
    PGADMIN_DEFAULT_PASSWORD=admin
    ```

5.  Generate the application key:

    ```bash
    php artisan key:generate
    ```

6.  Install Laravel Sail:

    ```bash
    docker compose build
    ```

7.  Install Laravel Sail:

    ```bash
    composer require laravel/sail --dev
    ```

8.  Start the Docker containers using Sail:

    ```bash
    ./vendor/bin/sail up -d
    ```

9.  Excecute tests:

    ```bash
    ./vendor/bin/sail test
    ```

10. Create url:

    ```bash
    ./vendor/bin/sail share
    ```
    This will provide you with a public URL that you can share with others, allowing them to access your local development server.


11. Monitoring
    ```bash
    ./vendor/bin/sail health:check
    ```
    Additionally, you can check the application status by navigating to http://localhost/pulse in your browser.
