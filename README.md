<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Additional Package
-   [Package L5-Swagger for Laravel] (https://github.com/DarkaOnLine/L5-Swagger/wiki)

## 🚀 Quick start 

1.  **Install Depedencies**

    Required `composer`

    ```shell
    composer i
    or
    composer install
    ```
2.  **Config Environment**

    Copy `.env.example` to new file `.env`
    ```shell
    cp .env.example .env
    ```
    
    - ##### Generate APP_KEY 
      ```shell
      php artisan key:generate
      ```
    - ##### Make Database
    
      ##### Launch your XAMPP 
    - > Click "Admin" on MySQL > Create Your Database

    - ##### Setup Database
      Change DB_DATABASE for connect to local DB
      ```dotenv
       APP_ENV=local
       DB_CONNECTION=mysql
       DB_HOST=127.0.0.1
       DB_PORT=3306
       DB_DATABASE=[YOUR_DB_NAME]
       DB_USERNAME=root
       DB_PASSWORD=
      ```
    
3. **Publish L5-Swagger on Laravel**
  
   For make sure Swagger isGenerate, run the command below
   ```shell
   php artisan l5-swagger:generate
   ```

4. **Migrate Database & Seeder**

    Make sure you have created Database in your local database, then If you **haven't migrated your database**, run the command below
    ```shell
    php artisan migrate --seed
    ```
    (Optional) Fresh Database,
    <br> if you want to make **database clean like scratch with seeder**
    run the command below
    ```shell
    php artisan migrate:fresh --seed
    ```

5. **Ready to launch on local server**

    ```shell
    php artisan serve
    ```

    Your site is now running at http://127.0.0.1:8000


6. **Running Testing**

   For the testing All API, run the command below

    ```shell
    php artisan test
    ```

    

## 🚀 API Documentation
   
#### Before you visit the documentation url, make sure the laravel local server and local database are running properly

-   [View Documentation](http://127.0.0.1:8000/api/documentation) 

