# laravel-heroku-base-boilerplate
Basic boilerplate stuff to get laravel running on heroku

Install this package via composer and run vendor:publish to quickly get your
laravel app ready to deploy to heroku or flynn with little effort on your part.

This also covers flynn.io as they are pretty much the same and reuse the same build packs.

## Install instructions

```
composer require gjrdiesel/laravel-heroku-base-boilerplate:dev-master
```

Add `GjrDiesel\LaravelPaas\PaasServiceProvider::class,` to your `config/app.php` file **under** the section:

```
/*
 * Package Service Providers...
 */
``` 

Then run

```
php artisan paas:setup
```

After that you are ready to push to heroku or flynn.

```
git push flynn master
```

## Details

Changes necessary:
- modify `composer.json` generate an app key, run migrations, etc after composer install
- add `.buildpacks` afaik this file is only for flynn, heroku discovers buildpacks easily
- add `Procfile` this indicates we want to use nginx and a custom config for laravel
- add `nginx.conf` large image upload and sets document root to /public
- modify `config/database.app` parse DATABASE_URL env provided by heroku/flynn
