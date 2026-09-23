# Laravel Request System

A Laravel-based request management system for DevOps Lab 1.

## Student Information
- **Name:** Cristian B Gubat
- **Course:** BS Information Technology
- **Year & Block:** 4 - 3

## Software Requirements
- PHP 8.2.12
- Composer 2.8.6
- Laravel 12.69.2
- MySQL 8.0 (via XAMPP)
- Git 2.47.1
- Visual Studio Code

## Laravel Installation Instructions
```bash
# Create new Laravel project
composer create-project laravel/laravel laravel_request_system

# Enter project directory
cd laravel_request_system

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure .env for MySQL 
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel_request_system_db
# DB_USERNAME=root
# DB_PASSWORD=

# Run database migrations
php artisan migrate

# Start development server
php artisan serve
