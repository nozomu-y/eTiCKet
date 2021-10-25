Installation
===

## Install dependencies
```sh
composer install
```

## Setup Laravel
```sh
cp .env.environment .env
```

Create mysql database and update `.env` file.

```sh
php artisan key:generate
php artisan migrate
php artisan db:seed --class=UsersTableSeeder
php artisan serve
```

## .htaccess
```htaccess
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>
    
    RewriteEngine On
    
    RewriteCond %{REQUEST_FILENAME} -d [OR]
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^ ^$1 [N]

    RewriteCond %{REQUEST_URI} (\.\w+$) [NC]
    RewriteRule ^(.*)$ public/$1 

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ server.php
</IfModule>

```
