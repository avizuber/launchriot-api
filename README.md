# launchriot-api
A Laravel Backend for Your Next MVP

# Getting Started:
* Note: This assumes that you're already familiar with Laravel through it's docs or lessons *
- After downloading, run the following:
- Run `composer install && composer update`
- Run `npm install && npm run dev`
- Setup `.env-sample` file with your database details and rename to `.env`
- Run `php artisan migrate`
- Run `php artisan db:seed`, this will create the roles (important) and some dummy users for testing
- Run `php artisan passport:install`
- Run `php artisan vendor:publish --tag=cors` (and do the same for any other package if you need to)
- Finally, run `php artisan serve` and your API is up and running.

