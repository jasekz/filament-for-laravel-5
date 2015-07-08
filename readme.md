## Filament: A Laravel PHP Framework Base Application

#### What Is It?
In a nutshell, this is a base application for [Laravel 5](https://github.com/laravel/laravel) which I use for most of my projects.  It's a 
essentially a skeleton with some common functionality across a typical web app.
* Login, logout functionality
* Multi user, multi-role access control management utilizing Zizaco/Entrust
* Bootstrapped UI
* Ajax-ified data posting
* jQuery wrapper for table pagination, sorting, search and displaying X 
number of entries

#### Setup
Setup is straight forward.  Just follow these steps, and you'll be on your way.
##### Step 1 - Get the code
```
        git clone git@github.com:jasekz/filament-for-laravel-5.git
```

##### Step 2 - Install
```
        cd filament-for-laravel-5
        curl -s http://getcomposer.org/installer | php
        php composer.phar install
```

##### Step 3 - DB
Create a database for the app.

##### Step 4 - Config
Rename **.env.example** to **.env** and enter your database credentials

##### Step 5 - System config
Set up your server/vhosts and make sure that **/storage** is writable.

##### Step 6 - Migrate and seed.
```
        php artisan migrate
        php artisan db:seed
```

##### Step 7 - Login
You should now be able to login to the system by navigating to the app in a browser.  The default credentials to log in are:
e: admin@yoursite.com
p: password

#### Example Usage
Please see the included controllers, models, services and views for usage examples.  


#### Package Credits
Filament makes use of the following packages in addition to packages included with the default Laravel install.

* **"zizaco/entrust": "dev-laravel-5"** - [https://github.com/Zizaco/entrust](https://github.com/Zizaco/entrust)
* **"doctrine/dbal": "2.4.4"** - [https://github.com/doctrine/dbal](https://github.com/doctrine/dbal)

---

## Laravel PHP Framework

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) [![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.png)](https://packagist.org/packages/laravel/framework) [![Build Status](https://travis-ci.org/laravel/framework.png)](https://travis-ci.org/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, and caching.

Laravel aims to make the development process a pleasing one for the developer without sacrificing application functionality. Happy developers make the best code. To this end, we've attempted to combine the very best of what we have seen in other web frameworks, including frameworks implemented in other languages, such as Ruby on Rails, ASP.NET MVC, and Sinatra.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the entire framework can be found on the [Laravel website](http://laravel.com/docs).

### Contributing To Laravel

**All issues and pull requests should be filed on the [laravel/framework](http://github.com/laravel/framework) repository.**

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)