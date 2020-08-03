# Schedulia | API

This is an API of Schedulia application.

## Pre-requisites

- PHP 7.4.7

- Postgres 12

- Redis 5

## Usage

The following sections describe dockerized environment.

But feel free to setup your own development environment you comfortable with.

Just keep versions of installed software to be consistent with the team and production environment (see [Pre-requisites](#pre-requisites) section). 

```bash
cp .env.example .env
docker-compose up -d
docker-compose run --rm composer composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

API is available on [http://localhost:8000](http://localhost:8000).

In case you use your own environment, make sure you configured services correctly in the `.env` file.

Also, to be sure you have enabled all required php extensions, for more details see base [Dockerfile](/.config/docker/php-base/Dockerfile).

If you would like to preserve Postgres data on your computer, you should rename `docker-compose.override.yml.example` to `docker-compose.override.yml`. It won't work for Windows users, but for *nix it should work fine.

## Debugging

To debug the application we highly recommend you to use xDebug, it is already pre-installed in dockerized environment, but you should setup your IDE. To do this see [the instruction](../docs/debug.md).

## Useful links

- [Laravel docs](https://laravel.com/docs/7.x/installation)
