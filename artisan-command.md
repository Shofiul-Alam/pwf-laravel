## Artisan Commands

php artisan migrate --help 

## Environment Variables 
.env file is storing all environments variables

app_url -

database_connections params
pgsql or mysql 

## Routes

Provider/Middleware - RouteServiceProvider 
Routes - api.php file 

## Model and Migration
Code first Model and Migration

php artisan make:model Employee

php artisan migrate:refresh --seed


### Pivot Table Migration 
php artisan category_product_table --create=category_product



## Controller 
php artisan make:controller Employee/EmployeeController -r

##Middleware 
php artisan make:middleware signatureMiddleware


