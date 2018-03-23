# authmanager
to managing your system's authority and permission menu

## About
In much more complext system information, sometimes it will take a hard times to manage menu and give some roles for user. 
When your system become more complex and bigger, user roles become more important to achieve. You have to integrate your menu,
roles and your user. This package contain some management system for having all those issue in one solution.
You can manage menu
You can manage event/role, such as admin, view only, save only, request, approve, etc
You can manage group user
You can manage all of them in permission

## Installation
The preferred method of installation is via [Packagist][] and [Composer][]. Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require rijolee/authmanager
```

edit your config/app.php
then in your provider section add
```bash
    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        ...
        rijolee\AuthManager\AuthManagerServiceProvider::class,

```

## Migration
This package contain migration file that create default tables that for authmanager, to do it just command
```bash
php artisan migrate
```

## Getting Start
to access the view to manager authmanager just put url /auhmanager in your browser
```bash
http://yourproject/authmanager
```
voila! you can manage your authority menu and permission for your project

## Spotlight
you can access function User::hasEvents($event_id, $menu_id) that return true or false based on your menu id and event id 
so you can use it in your system to know wether this user allow some function in your system

you can access route /authmanager/getmenu/{sys}/{rootid}  to return JSON data your menu based on parameter your system name {sys}
and your root id {rootid}
note: system name information is column in menu table, type 'all' if you wanna get all data

## Further Documentation
there will be further documentation for this package




