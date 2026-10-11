# Student360 — Smart Student Development & School Communication Platform

A web platform for tracking students academically, behaviorally, and personally — connecting school administrators, teachers, and parents around each student's full development, not just their grades.

## Project Scope (V1)

Student360 V1 is designed for students from KG to Grade 6 (ages 3 to 12).

This first version covers:
- Role-based login for administrators, teachers, and parents
- A centralized Student360 profile
- Quick, structured teacher updates
- An authorized parent view of selected student progress
- A parent consent screen with audit logging

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade / HTML / CSS / JavaScript
- **Database:** MySQL (via XAMPP)
- **Database Management:** phpMyAdmin
- **Version Control:** GitHub

## Getting Started

### Prerequisites
- PHP 8.2+, Composer, XAMPP (Apache + MySQL), Git

### Setup

1. Clone the repo and switch to develop, then install dependencies with composer install
2. Copy .env.example to .env and run php artisan key:generate
3. Open XAMPP, start Apache + MySQL, create a database named student360 in phpMyAdmin
4. Update .env: DB_DATABASE=student360, DB_USERNAME=root, DB_PASSWORD=
5. Run php artisan migrate --seed (this creates the demo data and demo accounts), then php artisan serve. The app runs at http://127.0.0.1:8000

### Running the tests

```
php artisan test
```

## Demo Accounts (local demo only)

These accounts are created by `php artisan migrate --seed`. They are for local testing and demos only. Never use these passwords on a real system.

| Role | Email | Password | Sees |
|---|---|---|---|
| Admin | admin@student360.test | password | Admin dashboard (real counts) |
| Teacher | teacher@student360.test | password | Teacher dashboard, all notes, add updates |
| Parent | parent@student360.test | password | Own child: Sara Demo (3A) |
| Parent | parent.khalil@student360.test | password | Own child: Ahmad Khalil (5A) |

Parents only see their own child and only the teacher updates marked as visible to parents. Confidential staff notes are never shown to parents.

## Branching
- main — stable code
- develop — active development
- feature/* — one branch per task

## Team — Nexus360

| Role | Name |
|---|---|
| Team Leader / Project Setup | Nagham Ratrout |
| Database Developer | Mariam Doghman |
| Roles & Demo Accounts | Reem Mortada |
| Login & Security | Hiba Hussieni |
| Frontend & Testing | Jana Shreif |