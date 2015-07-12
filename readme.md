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

