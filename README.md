Tyondo Mnara
===================
[![Laravel 5.3](https://img.shields.io/badge/Laravel-5.3-orange.svg?style=flat-square)](http://laravel.com)
[![Laravel 5.4](https://img.shields.io/badge/Laravel--5.4-Supported-brightgreen.svg)](http://laravel.com)
[![Source](http://img.shields.io/badge/source-tyondo/mnara-blue.svg?style=flat-square)](https://github.com/Rndwiga/mnara)
[![GitHub tag](https://img.shields.io/github/tag/strongloop/express.svg)]()
[![GitHub tag](https://img.shields.io/github/tag/strongloop/express.svg)]()
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

## A user management package

A laravel 5.3.^|5.4.^ complete user package. It has the following:
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
## Usage Live

1. Install the package via composer (for production)
````
composer require tyondo/mnara
````

2- Change the app/auth.php User Providers list from
````
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
     ]
````
to
````
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Tyondo\Mnara\Models\User::class,
        ],
     ]
````
## Installation
1. add the following files to the config/app.php file
````
Tyondo\Mnara\MnaraServiceProvider::class, //Mnara
````
Facades
````
'Mnara'    => Tyondo\Mnara\MnaraFacade::class, // not required, but available
    
````
Publish tyondo/mnara config files
````
php artisan vendor:publish --tag=migrations
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

## Error Resolution
If upon running php artisan migrate you ran to the error below:
````
SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 767 bytes (SQL: alter table `users
  ` add unique `users_email_unique`(`email`))
````
add the following lines to your app\Providers\AppServiceProvider.php file
use Illuminate\Support\Facades\Schema;
in the boot function() add Schema::defaultStringLength(191);
  
## Usage Production
1- create **packages** folder in the root directory of your laravel installation

2- inside package create **tyondo** folder.
 
3- inside **tyondo** folder run:
````
git clone https://github.com/Rndwiga/mnara.git
````

4- Add the package in your application's **composer.json** autoload section to make it available in your application. 
```
"psr-4": {
            "App\\": "app/",
            "Tyondo\\Mnara\\": "packages/tyondo/mnara/src"
        }
```

5- Run :

```
composer dump-autoload
```

6- Add the package service provider in your **config/app.php** file
````
Tyondo\Mnara\MnaraServiceProvider::class, //Mnara
````

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


##notes
Within the boot method, you may do whatever you like: register event listeners, include a routes file, register filters, or anything else you can imagine.”

So the register one is just for binding. The boot one is to actually trigger something to happen.