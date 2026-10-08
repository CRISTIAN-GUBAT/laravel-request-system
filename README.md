# Laravel Request System

A Laravel-based request management system for DevOps Lab 1, Lab 2, and Lab 3.
This project demonstrates project setup, MySQL integration, database modeling,
migrations, Git version control, and secure request access following secure DevOps practices.

## Student Information
- **Name:** Cristian B. Gubat
- **Course:** BS Information Technology
- **Year & Block:** 4 - 3

## Software Requirements
- PHP 8.2.12
- Composer 2.8.6
- Laravel 12.69.2
- MySQL 8.0 (via XAMPP)
- Git 2.47.1
- Visual Studio Code
- Laravel Breeze (Blade)

## Laravel Installation Instructions

```
Create new Laravel project
composer create-project laravel/laravel laravel_request_system

Enter project directory
cd laravel_request_system

Copy environment file
cp .env.example .env

Generate application key
php artisan key:generate

Configure .env for MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_request_system_db
DB_USERNAME=root
DB_PASSWORD=

Install Laravel Breeze
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build

Run database migrations
php artisan migrate

Seed fictional accounts
php artisan db:seed

Start development server
php artisan serve
```


Open: http://127.0.0.1:8000

## Database Name

laravel_request_system_db

## Database Import Instructions

Import via phpMyAdmin → Import → Choose file → Go.

## Request Table Fields (Lab 2 and Lab 3)

| Field | Type | Constraint | Purpose |
|---|---|---|---|
| id | BIGINT UNSIGNED | Primary Key, Auto | Unique request number |
| user_id | BIGINT UNSIGNED | Foreign Key, NULLABLE | Owner of the request |
| requester_name | VARCHAR(100) | NOT NULL | Person submitting the request |
| requester_email | VARCHAR(255) | NOT NULL | Contact address |
| item_name | VARCHAR(150) | NOT NULL | Requested item or service |
| quantity | INT UNSIGNED | NOT NULL | Requested quantity (> 0) |
| purpose | TEXT | NOT NULL | Reason for the request |
| status | VARCHAR(20) | DEFAULT 'pending' | Request state |
| created_at | TIMESTAMP | NULLABLE | Creation time |
| updated_at | TIMESTAMP | NULLABLE | Update time |

## Users Table Fields (Lab 3)

| Field | Type | Constraint | Purpose |
|---|---|---|---|
| id | BIGINT UNSIGNED | Primary Key, Auto | Unique user ID |
| name | VARCHAR(255) | NOT NULL | User's full name |
| email | VARCHAR(255) | UNIQUE | User's email |
| password | VARCHAR(255) | NOT NULL | Hashed password |
| is_admin | BOOLEAN | DEFAULT false | Administrator flag |
| created_at | TIMESTAMP | NULLABLE | Creation time |
| updated_at | TIMESTAMP | NULLABLE | Update time |

## Migration Commands (Lab 2 and Lab 3)

```
php artisan make:migration create_requests_table
php artisan migrate

php artisan make:migration add_user_id_to_requests_table --table=requests
php artisan migrate

php artisan make:migration add_is_admin_to_users_table --table=users
php artisan migrate
```


## Steps to Verify the Tables

1. Run `php artisan migrate:status` to confirm all migrations are marked as Ran.
2. Open phpMyAdmin and select `laravel_request_system_db`.
3. Click the `requests` table to view its structure.
4. Click the `users` table to view its structure.
5. Run `SELECT * FROM requests;` to view sample rows.

## User Stories (Lab 2)

1. **Requester:** As a requester, I want to submit a request with my name, email, item, quantity, and purpose so that I can formally ask for an item or service.
2. **Staff Reviewer:** As a staff reviewer, I want to view all submitted requests with their status and details so that I can evaluate and act on each request efficiently.
3. **Record Keeper:** As a record keeper, I want to browse and verify all stored requests with their timestamps so that I can maintain accurate records and audit request history.

## Access Policy (Lab 3)

Students may only view their own requests. An owner or administrator may view a specific request. Administrators may view all requests.

**Denial response:** 403 Forbidden

## Route Summary (Lab 3)

| Method | Route | Action | Authorization |
|---|---|---|---|
| GET | /requests | List requests | viewAny |
| GET | /requests/create | Show create form | create |
| POST | /requests | Store new request | create |
| GET | /requests/{id} | View request | view |
| PATCH | /requests/{id}/status | Update status | updateStatus |

## File Responsibilities (Lab 3)

| Component | File | Maintainer |
|---|---|---|
| Auth | routes/auth.php, app/Http/Controllers/Auth/ | Cristian B. Gubat |
| Policy | app/Policies/ServiceRequestPolicy.php | Cristian B. Gubat |
| Controller | app/Http/Controllers/ServiceRequestController.php | Cristian B. Gubat |
| Routes | routes/web.php | Cristian B. Gubat |
| Views | resources/views/requests/ | Alfie Dyne Castro |
| Tests | tests/Feature/ServiceRequestTest.php | Alfie Dyne Castro |

## Security Controls (Lab 3)

- **Server-side validation:** item_name (required, string, max 150), quantity (required, integer, min 1), purpose (required, string, max 2000).
- **Trusted field assignment:** user_id, requester_name, requester_email assigned from the signed-in account.
- **Escaped Blade output:** `{{ $serviceRequest->purpose }}` renders HTML literally.
- **CSRF protection:** `@csrf` and `@method('PATCH')` in all POST/PATCH forms.
- **Password hashing:** Laravel bcrypt via `Hash::make()`.
- **Secret exclusion:** `.gitignore` excludes `.env`; `.env.example` has no credentials.

## Testing Steps (Lab 3)

1. Guest accesses `/requests` → redirect to login.
2. Student A logs in → sees only own requests.
3. Student A accesses Student B's request → 403.
4. Student A sends PATCH → 403.
5. Admin logs in → sees all, updates status.
6. Invalid input (quantity 0, −1, non-integer, blank item) → validation error.
7. Spoofed fields (user_id, status, is_admin, role) → ignored.
8. Text `<b>LAB3</b>` → shown literally.
9. Missing CSRF → 419.
10. Invalid status → validation error.

## Commands Needed to Run the Project

```
composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan db:seed

php artisan serve
```

Open: http://127.0.0.1:8000

## GitHub Repository

https://github.com/CRISTIAN-GUBAT/laravel-request-system

## Laboratory 3 Verification

Verification instruction: Test administrator access and administrator-only status updates.