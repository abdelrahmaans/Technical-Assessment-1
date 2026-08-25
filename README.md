# Course Management RESTful API (Laravel)

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B%20%7C%208.3%2B-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x%20%7C%2012.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Sanctum](https://img.shields.io/badge/Auth-Laravel%20Sanctum-brightgreen)](https://laravel.com/docs/sanctum)
[![Tests](https://img.shields.io/badge/Tests-20%20Passed%20%2F%20120%20Assertions-success)](tests/Feature)

A clean, production-ready RESTful API for Course Management built from scratch using Laravel, Sanctum authentication, Repository & Service Layer architecture, and unified JSON error handling.

---

## 🔗 Submission Deliverables

- **GitHub Repository**: `https://github.com/USERNAME/REPO_NAME` *(Replace with your repository link)*
- **Postman Collection**: [`Course_Management_API.postman_collection.json`](Course_Management_API.postman_collection.json) *(Included in project root)*
- **Architecture**: Clean MVC + Repository Pattern + Service Layer + Form Requests + API Resources
- **Automated Tests**: 20 Feature Tests (120 assertions) - 100% Green

---

## 📋 Task Requirements Compliance Matrix

| Requirement (PDF Page 1-7) | Implementation Details | Status |
| :--- | :--- | :---: |
| **Clean Project** | Fresh Laravel installation (`laravel new`), Zero starter kits (No Breeze/Jetstream/UI) | ✅ 100% |
| **Authentication** | Pure Laravel Sanctum token auth (`/register`, `/login`, `/logout`, `/user`) | ✅ 100% |
| **Courses CRUD** | Full CRUD operations matching schema (`id`, `title`, `description`, `price`, `is_published`, `timestamps`) | ✅ 100% |
| **Search & Pagination** | Search by title (`?search=`), pagination (`?page=`, `?per_page=`), sorted by `created_at` DESC | ✅ 100% |
| **API Resources** | `CourseResource` and `UserResource` format all JSON output (no raw Eloquent models) | ✅ 100% |
| **Unified Response Format** | Standardized `{ success: true/false, message: "...", data: {...}/null }` | ✅ 100% |
| **Form Request Validation** | `RegisterRequest`, `LoginRequest`, `StoreCourseRequest`, `UpdateCourseRequest` | ✅ 100% |
| **Custom Error Handling** | Unified format for `401` Unauthorized, `404` Not Found, `422` Validation, `500` Server errors | ✅ 100% |
| **Database Seeder** | Seeds 10 realistic sample courses + default Admin user | ✅ 100% |
| **Bonus (+10 Points)** | 20 Feature Tests (120 assertions), DB Transactions, Repository Pattern & Service Layer, `?published=` filter | ✅ +10 Pts |

---

## ⚙️ 1. Project Installation & Setup Commands

### Prerequisites
- PHP `>= 8.2`
- Composer
- SQLite (or MySQL)

### Step-by-Step Installation:
```bash
# 1. Clone the repository
git clone https://github.com/USERNAME/REPO_NAME.git
cd REPO_NAME

# 2. Install PHP dependencies
composer install

# 3. Environment configuration
cp .env.example .env
php artisan key:generate
```

---

## 🗄️ 2. Database Configuration, Migrations & Seeders

The application is pre-configured to use **SQLite** (zero external configuration needed).

Run migrations and seed default sample data:
```bash
php artisan migrate:fresh --seed
```

### Start Local Server:
```bash
php artisan serve
```
Local API Base URL: `http://127.0.0.1:8000/api`

---

## 🔑 3. Default Test Credentials

Use these credentials to test authentication endpoints:

- **Email**: `admin@example.com`
- **Password**: `password123`

---

## 📡 4. Full List of API Endpoints

### A. Authentication Endpoints (Public & Protected)

| Method | Endpoint | Access | Description |
| :--- | :--- | :---: | :--- |
| `POST` | `/api/register` | Public | Register a new user & receive Bearer Token |
| `POST` | `/api/login` | Public | Login with email/password & receive Bearer Token |
| `POST` | `/api/logout` | Protected | Revoke active Bearer Token |
| `GET` | `/api/user` | Protected | Retrieve authenticated user profile |

### B. Course Management Endpoints (Protected by `auth:sanctum`)

| Method | Endpoint | Query Parameters | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/courses` | `page`, `per_page`, `search`, `published` | List courses (Paginated, sorted newest first) |
| `POST` | `/api/courses` | - | Create a new course record |
| `GET` | `/api/courses/{id}` | - | Show single course by ID |
| `PUT/PATCH` | `/api/courses/{id}` | - | Update an existing course record |
| `DELETE` | `/api/courses/{id}` | - | Delete a course record |

---

## 📦 5. Unified API Response Structure

### Success Response (`200 OK` / `201 Created`)
```json
{
  "success": true,
  "message": "Course created successfully",
  "data": {
    "id": 1,
    "title": "Mastering Laravel REST APIs",
    "description": "Building scalable REST APIs with Sanctum",
    "price": 99.99,
    "is_published": true,
    "created_at": "2026-08-25T17:00:00.000000Z",
    "updated_at": "2026-08-25T17:00:00.000000Z"
  }
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

## 🧪 6. Running Automated Tests

Run the complete feature test suite:
```bash
php artisan test
```
- **AuthTest (8 Tests)**: Registration, validation, duplicate emails, login, token revocation, profile access.
- **CourseTest (12 Tests)**: CRUD operations, 401 unauthenticated protection, 422 validation, 404 missing handling, pagination, title search, published filtering, and newest-first sorting.

---

## 📮 7. Postman Collection

Import [`Course_Management_API.postman_collection.json`](Course_Management_API.postman_collection.json) directly into Postman:
- Pre-configured with all endpoints and variable `{{base_url}}`.
- Automated test script on Login/Register captures and sets `{{bearer_token}}` automatically.

