@echo off
IF EXIST .env (
    echo .env file found. Starting Laravel server...
    php artisan storage:link
    php artisan serve
) ELSE (
    echo .env file not found. Setting up project...
    
    composer install
    copy .env.example .env
	php artisan key:generate
    php artisan migrate
    php artisan migrate:fresh --seed
    npm install
	npm run build
    php artisan storage:link
    php artisan serve
)
