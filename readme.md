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

6. Create a database. Use the login values in stap 8.
7. Open cmd, navigate to the project folder then run the following commands:

	```php artisan migrate:install```
	
	```php artisan migrate --seed```

8. Open .env.example and add your config values. Make sure to setup a mail service. [(laravel supports alot of mail services)](http://laravel.com/docs/5.0/mail). Save the file as '.env' in the root folder. 
   

9. You are done installing. Enjoy our project!

### License

PostRequest is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
