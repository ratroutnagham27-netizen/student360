# Student360 — Smart Student Development & School Communication Platform

A web platform for tracking students academically, behaviorally, and personally — connecting school administrators, teachers, and parents around each student's full development, not just their grades.

## Project Scope (V1)

This first version covers:
- Role-based login for administrators, teachers, and parents
- A centralized Student360 profile
- Quick, structured teacher updates
- An authorized parent view of selected student progress

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
5. Run php artisan migrate then php artisan serve — app runs at http://127.0.0.1:8000

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