# Laravel 5.3 User Package

A laravel 5.3^ complete user package. It has the following:
- 2 config files
- View files
- Migrations
- Seeds
- Routes
- Controllers
## Functionalities
- Create user
- Create roles
- Create permissions
- Assign permissions
- Sync permissions
- Manage roles and permission
- Manage users
## Usage

1. Install the package via composer (for production)
````
composer require tyondo/mnara
````

2- Change 

3- Customize **Package/PackageServiceProvider** with the correct namespace and the name of your package, and replace the $packageNamespace attribute.

```php

    protected $packageName = 'yourpackagename';

```

4- Add the package in your application's **composer.json** autoload section to make it available in your application. 

```

"psr-4": {
            "App\\": "app/",
            "Vendor\\Package\\": "packages/vendor/package/src/Package"
        }

```

5- Run :

```
composer dump-autoload
```

6- Add the newly create package's service provider to your **config/app.php** provider's list.

7- Have fun!

## Package dependencies

Laravel won't autoload the **vendor/** path in your package's development folder. Easiest workaround is to add them in your main application's composer.json.

But also ensure they are in the package json file

Resources:
http://dimsav.com/blog/9/git-repository-inside-composer-vendors

https://murze.be/2015/05/creating-packages/

https://mattstauffer.co/blog/conditionally-loading-service-providers-in-laravel-5
````````
$ git remote
composer
origin
$ git push origin development
````````

## Installation
1. add the following files to the config/app.php file
````
Tyondo\Mnara\MnaraServiceProvider::class, //Mnara
Caffeinated\Shinobi\ShinobiServiceProvider::class, // For RBAC
Collective\Html\HtmlServiceProvider::class, // For Mnara Forms to function
````
Facades
````
'Form'     => Collective\Html\FormFacade::class,  // required for Mnara Forms
'HTML'     => Collective\Html\HtmlFacade::class,   // required for Mnara Forms
'Shinobi'  => Caffeinated\Shinobi\Facades\Shinobi::class, // For RBAC functions
'Mnara'    => Tyondo\Mnara\MnaraFacade::class, // not required, but available
    
````
Publish shinobi service provider for the migration files
````
php artisan vendor:publish --provider="Caffeinated\Shinobi\ShinobiServiceProvider"
````
Publish tyondo/mnara config files
````
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=config-menu
````
Run laravel default auth generator. If its a new project
````
php artisan make:auth
````
Run migration
````
php artisan migrate
````
Seed the database with default user. Skip this if you already have users
````
php artisan db:seed --class="Tyondo\Mnara\Database\seeds\DefaultUser"
````
Seed the database with default permission and roles
````
php artisan db:seed --class="Tyondo\Mnara\Database\seeds\MnaraTableSeeder"
````
Change the default auth provider in app\auth.php
````
'model' => Tyondo\Mnara\Models\User::class,
````
##notes
Within the boot method, you may do whatever you like: register event listeners, include a routes file, register filters, or anything else you can imagine.”

So the register one is just for binding. The boot one is to actually trigger something to happen.