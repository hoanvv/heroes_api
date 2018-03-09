# Shipping Service API
Shipping Service API is developed by Laravel Framework
## Getting Started
### Set up environment
```
- Install web server application (Xampp or Ngix), composer
- Configure PHP
( You can search on internet to get detailed instructions )
```
### Run project
```
1. git clone https://github.com/hoanvv/heroes_api.git
2. cd heroes_api
3. Duplicate .env.example and change to .env
4. Change these fields:
- DB_DATABASE=[your_name_database]
- DB_USERNAME=[your_username]
- DB_PASSWORD=[your_password]
( Note: create mysql database before do this step ) 
5. composer install
6. php artisan key:generate
7. php artisan migrate ( Remember turn on mysql server before run it )
8. composer dump-autoload
9. php artisan db:seed --class=DatabaseSeeder
10. php artisan serve
```
## Shipping Service API List
[Link](https://github.com/hoanvv/heroes_api/API-List.md)

