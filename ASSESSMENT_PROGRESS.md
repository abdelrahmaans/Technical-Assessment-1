# Course Management REST API - Implementation Tracker

## 📌 Project Overview
- **Role**: Junior Backend Developer (Laravel)
- **Framework**: Laravel 11 (Clean Installation, No Starter Kits)
- **Authentication**: Laravel Sanctum ONLY
- **Status**: 🚀 In Progress (Phase 1 Complete)

---

## 🎯 Assessment Requirements & Scoring Matrix (100 pts + 10 Bonus)

| Criteria | Points | Status | Details |
| :--- | :---: | :---: | :--- |
| **Project runs without errors** | 15 | ⏳ Pending | Clean project initialized; migrations & tests in progress |
| **Authentication (Sanctum)** | 20 | ⏳ Pending | Register, Login (token), Logout (token revocation) |
| **Courses CRUD** | 20 | ⏳ Pending | Create, List, Show, Update, Delete with exact schema |
| **Search + Pagination + Sorting** | 10 | ⏳ Pending | `?search=`, `?page=`, sorted by `created_at` DESC |
| **API Resources usage** | 10 | ⏳ Pending | `CourseResource`, `UserResource`, no direct Eloquent models |
| **Unified Response Format** | 10 | ⏳ Pending | Standardized `{ success, message, data }` |
| **Validation + Error Handling** | 10 | ⏳ Pending | Form Requests + custom handler (401, 404, 422, 500) |
| **Clean Code & Project Structure** | 5 | ⏳ Pending | Controllers, FormRequests, Resources, PSR-12 |
| **Bonus Criteria** | +10 | ⏳ Pending | Feature Tests, DB Transactions, Service/Repo Layer, Published Filter |
| **Total Potential Score** | **110/110** | | |

---

## 🛡️ Anti-Disqualification Checklist
- [x] Started from fresh `laravel new` / clean composer install (No starter kit)
- [x] No Laravel Breeze
- [x] No Laravel Jetstream
- [x] No Laravel UI
- [x] Only Laravel Sanctum allowed for API auth
- [x] No sensitive files in Git (verified `.gitignore` ignores `.env`)
- [x] Structured multiple Git commits

---

## 📋 API Endpoints Specification

### Authentication
- `POST /api/register` (Public) - Register new user & return access token
- `POST /api/login` (Public) - Authenticate & return access token
- `POST /api/logout` (Protected) - Revoke active bearer token
- `GET /api/user` (Protected) - Get current authenticated user profile

### Courses (All Protected via `auth:sanctum`)
- `GET /api/courses` - Paginated course list (supports `?search=`, `?page=`, `?published=`)
- `POST /api/courses` - Create a new course
- `GET /api/courses/{id}` - Retrieve single course by ID
- `PUT/PATCH /api/courses/{id}` - Update existing course
- `DELETE /api/courses/{id}` - Remove course

---

## 🚀 Development Milestones
- [x] **Milestone 1**: Environment setup (PHP 8.3, Composer, Laravel 11, Sanctum, Git init)
- [ ] **Milestone 2**: Database layer (Course migration, model, factories, 10-course seeder, user seeder)
- [ ] **Milestone 3**: Unified Response Handler & Exception Formatter (401, 404, 422, 500)
- [ ] **Milestone 4**: Sanctum Authentication API (Form Requests, AuthService, AuthController)
- [ ] **Milestone 5**: Repository & Service Layer + Course CRUD + Filtering / Search / Sorting
- [ ] **Milestone 6**: Automated Feature Test Suite (Auth, CRUD, Filtering, Errors)
- [ ] **Milestone 7**: Deliverables (README.md, Postman Collection, .env.example, Git commits)
