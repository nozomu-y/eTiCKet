Installation
===

## Install dependencies
```sh
comoser install
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

