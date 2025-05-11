<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## Nina.care Application (Work in progress)

This project is a web application built with **Laravel**, **Vue.js**, and **Inertia.js**.

> ⚠️ This README is a work in progress and will continue to evolve as the project matures.

---

## Tech Stack
- **PHP 8.2+** - Server-side scripting language  
- **Laravel** – Backend framework for routing, business logic, and database management  
- **Vue.js (Vue 3)** – Modern JavaScript framework for reactive and component-based UI  
- **Inertia.js** – Middleware to bridge Laravel and Vue without the need for a REST API  
- **MySQL 8+** - Relational database
- **Git** - Application versioning
- **Docker** - (optional) Containerization  
---

## Features (WIP)

- User authentication (and role-based access control coming soon)
- Data seeders
- Modern and responsive UI  
- Admin dashboard and user portal  
- Create, edit, and delete an user


---

## Getting Started
### Clone the repository
```bash
git clone https://github.com/LudoPilot/ninacare-laravel-vue.git
```
or
```bash
git clone git@github.com:LudoPilot/ninacare-laravel-vue.git
```

### Install dependencies
Go to the project folder.
```bash
cd ninacare-laravel-vue
composer install
npm install
```

### Configure environment
Create an .env environment file. DO NOT COMMIT THIS FILE! 
Edit the following variables. The following values are given as examples.
```bash
DB_HOST=db	# same as container_name in docker-compose.yaml
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel
DB_PASSWORD=secret
```

Generate an application key if necessary.
```bash
php artisan key:generate
```

## Run migrations
```bash
php artisan migrate
```
This command creates the tables in the database.

## Seed the database
```bash
php artisan db:seed
```
This commands insert fake users into the `users` table.

## (Optional) Reset the database
```bash
php artisan migrate:fresh
```

## Launch the development server
```bash
php artisan serve
npm run dev
```
OR 
```bash
composer run dev
```


# Run the application with Docker
## Prerequisites
Docker must be installed on your machine.
If you are on Windows, you must have WSL2 and Docker Desktop.

## Launch Docker.
Launch Docker Desktop. Open a terminal and go to the project folder.
```bash
docker-compose up -d
```
This process can take several minutes the first time because Docker has to build the image.

Wait a few seconds and launch migrations.
```bash
docker logs laravel_db
```

```bash
docker exec -it laravel_app php artisan migrate
```


Seed the database.
```bash
docker exec -it laravel_app php artisan db:seed
```
Here, `laravel_app` is the name of the container (defined in docker-compose.yaml).

## Useful tip: empty the cache if necessary.
```bash
docker exec -it laravel_app php artisan config:clear
docker exec -it laravel_app php artisan cache:clear
```