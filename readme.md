## Post Request Project

### Installation guide

This guide will be a fast setup guide.

1. Download and install [Composer](https://getcomposer.org/download/).
2. Open cmd, and run the following command:

	```composer global require "laravel/installer=~1.1"```
	
3. Download the project from github.
4. Open cmd, navigate to the project folder.
5. Run the following command:

    ```composer update```

6. Create a mysql database named: "LunchTime"
7. Open cmd, navigate to the project folder then run the following commands:

	```php artisan migrate:install```
	
	```php artisan migrate```

	```php artisan db:seed```
	
8. You are done installing. Enjoy our project!

### License

LunchTime is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
