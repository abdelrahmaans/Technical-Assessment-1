# Course Management RESTful API

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B%20%7C%208.3%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x%20%7C%2012.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Sanctum](https://img.shields.io/badge/Auth-Laravel%20Sanctum-brightgreen)](https://laravel.com/docs/sanctum)
[![Tests](https://img.shields.io/badge/Tests-20%20Passed%20%2F%20120%20Assertions-success)](tests/Feature)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

A robust, enterprise-grade RESTful API for Course Management built with Laravel, adhering to clean architecture principles, strict RESTful design standards, and comprehensive automated test coverage.

---

## 📑 Table of Contents

- [Architectural Highlights](#-architectural-highlights)
- [Requirements](#-requirements)
- [Installation & Setup](#-installation--setup)
- [Database Seeding & Test Credentials](#-database-seeding--test-credentials)
- [Unified API Response Structure](#-unified-api-response-structure)
- [API Endpoints Reference](#-api-endpoints-reference)
  - [Authentication Endpoints](#1-authentication-endpoints)
  - [Course Management Endpoints](#2-course-management-endpoints)
- [Query Parameters & Filtering](#-query-parameters--filtering)
- [Error Handling & HTTP Status Codes](#-error-handling--http-status-codes)
- [Postman Collection](#-postman-collection)
- [Running Automated Tests](#-running-automated-tests)
- [Project Structure](#-project-structure)

---

## 🏛 Architectural Highlights

- **Clean MVC + Service + Repository Layers**: Complete separation of concerns.
  - **Controllers**: Thin controllers handling HTTP requests and returning standardized JSON responses.
  - **Form Requests**: Dedicated request classes encapsulating validation rules (`RegisterRequest`, `LoginRequest`, `StoreCourseRequest`, `UpdateCourseRequest`).
  - **Service Layer**: Business logic encapsulation (`AuthService`, `CourseService`) with **Database Transactions** for atomic mutations.
  - **Repository Pattern**: Abstracted database access using `CourseRepositoryInterface` bound to Eloquent `CourseRepository` via `AppServiceProvider`.
  - **API Resources**: Strict response transformations via `CourseResource` and `UserResource`. Direct Eloquent models are never exposed.
- **Pure Sanctum Authentication**: Zero boilerplate/starter kit dependencies (No Breeze, Jetstream, or Laravel UI). Token-based authentication using personal access tokens.
- **Unified Global Exception Handler**: Centrally handled in `bootstrap/app.php` ensuring all errors (401, 404, 422, 500) follow the unified response format.

---

## ⚙ Requirements

- **PHP**: `^8.2` or `^8.3`
- **Composer**: `^2.x`
- **Database**: SQLite (default, zero configuration) or MySQL / PostgreSQL
- **PHP Extensions**: `pdo_sqlite`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`

---

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone <repository-url>
cd Technical-Assessment-1
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup & Migration
By default, the application is pre-configured to use **SQLite**. If you wish to use MySQL, configure `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` inside `.env`.

Run the migrations and seed sample data:
```bash
php artisan migrate:fresh --seed
```

### 5. Start the Development Server
```bash
php artisan serve
```
The API will be available at: `http://127.0.0.1:8000/api`

---

## 🔑 Database Seeding & Test Credentials

The database seeder (`php artisan db:seed`) creates:
1. **Default Test User**:
   - **Email**: `admin@example.com`
   - **Password**: `password123`
2. **10 Production-Ready Sample Courses** with various titles, prices, publication statuses, and staggered timestamps for pagination/sorting verification.

---

## 📦 Unified API Response Structure

All API responses strictly adhere to the unified standard:

### Success Response (`200 OK` / `201 Created`)
```json
{
  "success": true,
  "message": "Course created successfully",
  "data": { ... }
}
```

### Error Response (`401`, `404`, `422`, `500`)
```json
{
  "success": false,
  "message": "Validation Error",
  "data": null
}
```

---

## 📡 API Endpoints Reference

### 1. Authentication Endpoints

| Method | Endpoint | Access | Description |
| :--- | :--- | :---: | :--- |
| `POST` | `/api/register` | Public | Register new user and return Bearer token |
| `POST` | `/api/login` | Public | Authenticate user credentials and return Bearer token |
| `POST` | `/api/logout` | Protected | Revoke the current Bearer token |
| `GET` | `/api/user` | Protected | Retrieve authenticated user profile |

#### Register (`POST /api/register`)
**Request Body:**
```json
{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "password123"
}
```
**Response (`201 Created`):**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 2,
      "name": "John Doe",
      "email": "johndoe@example.com",
      "created_at": "2026-08-23T17:50:00.000000Z",
      "updated_at": "2026-08-23T17:50:00.000000Z"
    },
    "token": "1|AbCdEf123456...",
    "token_type": "Bearer"
  }
}
```

#### Login (`POST /api/login`)
**Request Body:**
```json
{
  "email": "admin@example.com",
  "password": "password123"
}
```
**Response (`200 OK`):**
```json
{
  "success": true,
  "message": "User logged in successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "created_at": "2026-08-23T17:48:28.000000Z",
      "updated_at": "2026-08-23T17:48:28.000000Z"
    },
    "token": "2|XyZ987...",
    "token_type": "Bearer"
  }
}
```

---

### 2. Course Management Endpoints

> **Note**: All course endpoints require the `Authorization: Bearer <token>` header.

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/courses` | List courses with pagination, search, filter, and newest-first sorting |
| `POST` | `/api/courses` | Create a new course record |
| `GET` | `/api/courses/{id}` | Retrieve details of a specific course |
| `PUT/PATCH` | `/api/courses/{id}` | Update an existing course record |
| `DELETE` | `/api/courses/{id}` | Remove a course record |

#### List Courses (`GET /api/courses?page=1&per_page=10&search=Laravel&published=true`)
**Response (`200 OK`):**
```json
{
  "success": true,
  "message": "Courses retrieved successfully",
  "data": {
    "items": [
      {
        "id": 10,
        "title": "Laravel Eloquent ORM: From Beginner to Pro",
        "description": "Unlock the full power of Eloquent relationships...",
        "price": 65.0,
        "is_published": true,
        "created_at": "2026-08-22T17:48:28.000000Z",
        "updated_at": "2026-08-22T17:48:28.000000Z"
      }
    ],
    "pagination": {
      "current_page": 1,
      "per_page": 10,
      "total": 1,
      "last_page": 1,
      "from": 1,
      "to": 1,
      "has_more_pages": false
    }
  }
}
```

#### Create Course (`POST /api/courses`)
**Request Body:**
```json
{
  "title": "Advanced Microservices in Laravel",
  "description": "Learn event-driven architecture and message brokers.",
  "price": 149.99,
  "is_published": true
}
```
**Response (`201 Created`):**
```json
{
  "success": true,
  "message": "Course created successfully",
  "data": {
    "id": 11,
    "title": "Advanced Microservices in Laravel",
    "description": "Learn event-driven architecture and message brokers.",
    "price": 149.99,
    "is_published": true,
    "created_at": "2026-08-23T17:51:00.000000Z",
    "updated_at": "2026-08-23T17:51:00.000000Z"
  }
}
```

#### Show Course (`GET /api/courses/{id}`)
**Response (`200 OK`):**
```json
{
  "success": true,
  "message": "Course retrieved successfully",
  "data": {
    "id": 1,
    "title": "Mastering Laravel 11 RESTful API Development",
    "description": "Comprehensive guide to building production-ready REST APIs...",
    "price": 99.99,
    "is_published": true,
    "created_at": "2026-08-13T17:48:28.000000Z",
    "updated_at": "2026-08-13T17:48:28.000000Z"
  }
}
```

#### Update Course (`PUT /api/courses/{id}`)
**Request Body:**
```json
{
  "title": "Mastering Laravel 11 RESTful API Development (2026 Edition)",
  "price": 119.99
}
```
**Response (`200 OK`):**
```json
{
  "success": true,
  "message": "Course updated successfully",
  "data": {
    "id": 1,
    "title": "Mastering Laravel 11 RESTful API Development (2026 Edition)",
    "description": "Comprehensive guide to building production-ready REST APIs...",
    "price": 119.99,
    "is_published": true,
    "created_at": "2026-08-13T17:48:28.000000Z",
    "updated_at": "2026-08-23T17:52:00.000000Z"
  }
}
```

#### Delete Course (`DELETE /api/courses/{id}`)
**Response (`200 OK`):**
```json
{
  "success": true,
  "message": "Course deleted successfully",
  "data": {}
}
```

---

## 🔍 Query Parameters & Filtering

| Parameter | Type | Default | Example | Description |
| :--- | :---: | :---: | :--- | :--- |
| `page` | integer | `1` | `?page=2` | Pagination page number |
| `per_page` | integer | `10` | `?per_page=5` | Number of courses per page |
| `search` | string | `null` | `?search=Laravel` | Performs case-insensitive title search |
| `published` | boolean | `null` | `?published=true` | Filter by published (`true`) or draft (`false`) courses |
| *Default Sorting* | timestamp | - | - | Automatically sorted by `created_at` DESC (newest first) |

---

## 🛑 Error Handling & HTTP Status Codes

The API returns standardized JSON responses across all HTTP error statuses:

| Status Code | Scenario | Sample Response |
| :---: | :--- | :--- |
| **`401 Unauthorized`** | Missing or invalid Bearer token | `{"success": false, "message": "Unauthorized access. Please provide a valid authentication token.", "data": null}` |
| **`404 Not Found`** | Course ID does not exist | `{"success": false, "message": "Resource not found", "data": null}` |
| **`422 Unprocessable`** | Form validation failed | `{"success": false, "message": "Validation Error", "data": null}` |
| **`500 Server Error`** | Unhandled internal exception | `{"success": false, "message": "Internal Server Error", "data": null}` |

---

## 📮 Postman Collection

A complete Postman collection is included in the root directory:
- **File**: `Course_Management_API.postman_collection.json`
- **Features**:
  - Automatically captures and populates `{{bearer_token}}` variable upon login/registration.
  - Organized by `Authentication`, `Courses CRUD & Filtering`, and `Error Scenarios`.

**Import Steps**:
1. Open Postman.
2. Click **Import** and select `Course_Management_API.postman_collection.json`.
3. Set the `base_url` variable if running on a custom port (default: `http://127.0.0.1:8000/api`).

---

## 🧪 Running Automated Tests

Run the full automated test suite containing unit and feature tests:

```bash
php artisan test
```

### Test Coverage Highlights:
- **AuthTest**: User registration, login validation, token issuance, token revocation on logout, profile access, and invalid credentials.
- **CourseTest**: Full CRUD workflows, missing required fields validation (422), 404 on missing records, unauthenticated protection (401), search filtering, published boolean filtering, and newest-first descending sorting.

---

## 📂 Project Structure

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php      # Registration, Login, Logout, Profile
│   │   │       └── CourseController.php    # Course CRUD & Listings
│   │   ├── Requests/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginRequest.php        # Login validation
│   │   │   │   └── RegisterRequest.php     # Registration validation
│   │   │   └── Course/
│   │   │       ├── StoreCourseRequest.php  # Course creation validation
│   │   │       └── UpdateCourseRequest.php # Course update validation
│   │   └── Resources/
│   │       ├── CourseResource.php          # Course API transformation
│   │       └── UserResource.php            # User API transformation
│   ├── Models/
│   │   ├── Course.php                      # Course model with scopes
│   │   └── User.php                        # User model with HasApiTokens
│   ├── Repositories/
│   │   ├── Contracts/
│   │   │   └── CourseRepositoryInterface.php
│   │   └── Eloquent/
│   │       └── CourseRepository.php        # Eloquent repository implementation
│   ├── Services/
│   │   ├── AuthService.php                 # Auth business logic
│   │   └── CourseService.php               # Course business logic & DB transactions
│   └── Traits/
│       └── ApiResponseTrait.php            # Standardized API response helper
├── bootstrap/
│   └── app.php                             # Routing & Global Exception Handler
├── database/
│   ├── factories/
│   │   ├── CourseFactory.php
│   │   └── UserFactory.php
│   ├── migrations/
│   │   └── 2026_08_22_112633_create_courses_table.php
│   └── seeders/
│       ├── CourseSeeder.php                # 10 realistic courses
│       └── DatabaseSeeder.php              # Admin user & course seeder runner
├── routes/
│   └── api.php                             # RESTful API route definitions
└── tests/
    └── Feature/
        ├── AuthTest.php                    # 8 feature test cases
        └── CourseTest.php                  # 12 feature test cases
```
