educal
=========

educal is an application for schools to easily create and manage calendars that can be shared with parents.

##Developed with
* Laravel 4.2
* Cartalyst Sentry
* jQuery for public view
* AngularJs for admin view
* Twitter Bootstrap
* FullCalendar http://fullcalendar.io

###Development dependencies:
* bower
* grunt
* sass
* uglify

##How to install
Make sure you have composer installed
> [Install composer](https://getcomposer.org/doc/00-intro.md)

Begin by installing the required packages through Composer.

    composer install
    
You also need to install bower, and need to run grunt in order to compile the necesarry css files. This can be done by navigating to the project root folder and running

    npm install
    npm install -g bower grunt-cli
    bower install
    grunt
    
Next change your database credentials. This is necessary to store data.

* Go to folder app/config
* Copy the file database.php to app/config/local
* Update the new database.php file with your own database credentials
* [database credentials](http://laravel.com/docs/database)
    
Set up your mail server credentials. This is necessary to send password reset mails.
    
* Go to folder app/config
* Copy the file mail.php to app/config/local
* Update the new mail.php file with your own mail credentials
* [database credentials](http://laravel.com/docs/4.2/mail#configuration)
    
Finally run the migrations to create your database.

    php artisan migrate
    
If your development environment is not on a '.dev' domain, you will have to change the following line of code in bootstrap/start.php:

> $env = $app->detectEnvironment(array(
	'local' => array('*.dev'),
));

And change '\*.dev' to your computer name or simply '\*'

## Server configuration
Server configuration is identical to the default laravel 4.2 server configuration.
See: http://laravel.com/docs/4.2#pretty-urls

## Nginx example configuration
Example of nginx configuration for the site:

    server {
        listen 80 default_server;
        listen [::]:80 default_server ipv6only=on;
    
        root /var/www/educal.gent.be;
        index index.php index.html index.htm;
        server_name educal.gent.be;
    
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
        location ~ \.php$ {
            try_files $uri /index.php =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass unix:/var/run/php5-fpm.sock;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include fastcgi_params;
        }
    }

## Creating schools and users
A school needs to be created by filling out the register form. Both a school and first user will be created.
This first user is an admin of the school and can add more users from the dashboard.
If you want to add an account, without adding a school, the user needs to be added from an existing school's dashboard.
Upon adding a user from a school's dashboard, an email will be sent to the new user, asking to setup a password.

## Login
Login by clicking on login. Depending on the role of the currently logged in user you can perform certain actions

* Admin: manage your school (users, calendars, information)
* Editor: add/edit events on the calendars you're assigned to.
* User (not logged in): view calendars

## What is this?
Schools can have a lot of activities throughout the year such as commitee meetings, open days for the public, kid's parties, etc. This can be hard to keep track of for parents. Educal centralizes and creates an easy-to-use link to import the school's agenda.

This project has been programmed during the open Summer of code 2014 and worked further upon during open Summer of code 2015.

## Credit
Authors: Bert Marcelis, Bruce Vansteenwinkel, Thomas Ghysels

Past Authors: Sander Meert, Bjorn Van Acker, Nick Denys

Special thanks to the City of Ghent, Digipolis, Jan Vansteelandt, Miet Claes, Pieter Colpaert and Xavier Bertels.
