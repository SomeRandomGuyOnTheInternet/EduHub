# EduHub

EduHub is an open-source Learning Management System (LMS).

## Installation
Subject to change, still need install stuff for database.
- Install PHP
- Install Composer
- Install Node and NPM
- Install MySQL

## Deployment
Deployed on Azure: http://eduhub-web.azurewebsites.net

## Run
**Note:** A .env file is needed to run the app. Contact admin for more details.<br>
Run the following code.

> ```
> cd src
> ```
> ```
> php artisan serve
> ```

## Steps to Run (04/04/2024)
1. Run composer install in terminal
2. Rename .env.example to .env
3. In .env, change DB password (line 27)
4. In MySQL Workbench, create a database named eduhub_db
5. Run php artisan migrate in terminal
6. Run php artisan key:generate in terminal
7. Run php artisan storage:link in terminal
8. Run php artisan migrate:fresh --seed in terminal
9. Run php artisan storage:link in terminal
10. Run php artisan optimize in terminal
11. Run npm install in terminal
12. Run npm run dev in terminal
13. Open another terminal, run php artisan serve

## If you have already set it up and there were migration changes
1. Run php artisan migrate:fresh --seed in terminal if you want to delete all records and seed with default records
2. Run php artisan db:seed if you want to seed with default records but not lose previous records (might have conflicts)

## Login Information
1. Admin
- Username: admin@eduhub.com
- Password: password
2. Professor
- Username: binder@eduhub.com
- Password: password
3. Student
- Username: abdul.hakam@eduhub.com
- Password: password