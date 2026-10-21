
# Student360 — Smart Student Development & School Communication Platform

A web platform for tracking students academically, behaviorally, and personally — connecting school administrators, teachers, and parents around each student's full development, not just their grades.

## Screenshots

### Login
<img width="1356" height="647" alt="login" src="https://github.com/user-attachments/assets/69dcf449-198e-4fab-93a2-2f082102c711" />

### Privacy consent (parents)
<img width="1357" height="649" alt="consent" src="https://github.com/user-attachments/assets/850db881-ce56-437d-b1ca-0a6ee28b5cfd" />


### Parent dashboard
<img width="1356" height="649" alt="parent" src="https://github.com/user-attachments/assets/74a0a037-3917-435f-8de2-c5371a5c134f" />


### Parent: student profile
<img width="1356" height="646" alt="image" src="https://github.com/user-attachments/assets/26443c4b-02fa-4439-b956-ee6b410bb248" />


### Teacher: add an update

<img width="1339" height="638" alt="Teacher" src="https://github.com/user-attachments/assets/5dc7b8f8-9343-4f01-a59a-9f3d37755f61" />


### Teacher dashboard
<img width="1356" height="645" alt="image" src="https://github.com/user-attachments/assets/2a528a77-4a94-4bfd-b1c9-ea7037cd7273" />


### Admin dashboard
<img width="1348" height="649" alt="Admin" src="https://github.com/user-attachments/assets/a8e6a51f-7436-44c8-a789-622a2fadc97b" />


## Project Scope (V1)

Student360 V1 is designed for students from KG to Grade 6 (ages 3 to 12).

This first version covers:
- Role-based login for administrators, teachers, and parents
- A centralized Student360 profile
- Quick, structured teacher updates
- An authorized parent view of selected student progress
- A parent consent screen with audit logging

## Main Features

**Completed**
- Role-based login for admin, teacher and parent, with a 403 page when a role opens a page it should not
- Teacher dashboard and a form to add structured updates (academic, behavioral, personal) for the teacher's own homeroom students, with input validation
- "Visible to parent" option on each update; confidential staff notes are never shown to parents
- Parent dashboard showing only their own child and the updates shared with them
- Parent consent screen on first login, saved with a timestamp and written to the audit log
- Audit log for student edits, new teacher updates and consent
- Admin dashboard with real database counts
- Automated tests (64 passing)

**Partly done**
- Academic average and attendance on the student profile are labelled sample data

**Not built yet**
- Parent–teacher messaging
- Admin screens to add and edit students and users

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
