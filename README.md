# Majoo Test Case Web Dev

## Installation

```sh
git clone https://github.com/hamzahfauzy/majoo_test
cd majoo_test
composer install
cp .env.example .env
php artisan key:generate
```

Config database such as database name, database username, and database password in .env file

Change FILESYSTEM_DRIVER to public in .env file
Add port 8000 to APP_URL in .env file

## Then Run

```sh
php artisan migrate
```

## Run Serve
```sh
php artisan serve
```

## Register First
```sh
http://localhost:8000/register
```