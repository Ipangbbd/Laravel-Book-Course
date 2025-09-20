```markdown
# 🎓 Xperium Academy - Laravel Booking System  
*Book Courses Seamlessly, Manage with Ease*  

![Last Commit](https://img.shields.io/github/last-commit/Ipangbbd/Laravel-Book-Course) 
![Top Language](https://img.shields.io/github/languages/top/Ipangbbd/Laravel-Book-Course) 
![Languages](https://img.shields.io/github/languages/count/Ipangbbd/Laravel-Book-Course) 
![Repo Size](https://img.shields.io/github/repo-size/Ipangbbd/Laravel-Book-Course) 
![License](https://img.shields.io/github/license/Ipangbbd/Laravel-Book-Course)  

---

### 🛠 Built with the tools and technologies  
![Laravel](https://skillicons.dev/icons?i=laravel) 
![PHP](https://skillicons.dev/icons?i=php) 
![MySQL](https://skillicons.dev/icons?i=mysql) 
![Composer](https://skillicons.dev/icons?i=composer) 
![NodeJS](https://skillicons.dev/icons?i=nodejs) 
![Npm](https://skillicons.dev/icons?i=npm) 
![Vite](https://skillicons.dev/icons?i=vite) 
![Html](https://skillicons.dev/icons?i=html) 
![Css](https://skillicons.dev/icons?i=css) 
![Js](https://skillicons.dev/icons?i=javascript) 
![Markdown](https://skillicons.dev/icons?i=markdown) 
![Json](https://skillicons.dev/icons?i=json)  

---

## 📑 Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Usage](#usage)
- [Technologies](#technologies)
- [License](#license)

---

## 📖 Overview  
**Xperium Academy - Laravel Booking System** is a course booking and management platform built with Laravel.  
It provides an **admin dashboard** for managing courses, schedules, instructors, and bookings, and a **student-facing interface** for browsing courses and making reservations.  

---

## ✨ Features
- 👨‍🏫 **Admin Dashboard** — manage courses, instructors, schedules, and bookings  
- 📅 **Booking Management** — students can register for available schedules  
- 🧾 **Role-based Authentication** — separate access for Admin and Students  
- 💾 **Database Seeding** — pre-populated sample data for testing  
- 📤 **File Uploads** — support for course thumbnails and assets  
- 📧 **Email-ready** — booking confirmations and notifications (via Mailtrap/SMTP)  

---

## 📂 Project Structure
```

laravel-book-course/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   └── Public/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/
│       └── public/
├── routes/
│   └── web.php
├── .env.example
└── README.md

````

---

## 🚀 Getting Started  

1. **Clone the repository**  
```bash
git clone -b better-views https://github.com/Ipangbbd/Laravel-Book-Course.git
````

2. **Navigate to the project folder**

```bash
cd Laravel-Book-Course
```

3. **Install PHP dependencies**

```bash
composer install
```

4. **Copy `.env` and generate key**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Install Node dependencies**

```bash
npm install
npm run dev
```

6. **Run migrations & seeders**

```bash
php artisan migrate --seed
```

7. **Start the server**

```bash
php artisan serve
```

---

## 🎮 Usage

* 👩‍🎓 Students: Browse available courses & book schedules
* 🧑‍💼 Admin: Create & manage courses, instructors, and bookings
* 📊 Dashboard: View active bookings, confirm/cancel reservations
* 🖼️ Upload: Add thumbnails for courses to enhance visibility

---

## 🧰 Technologies

* **Laravel 10+** — backend framework
* **Blade Templates** — frontend rendering
* **MySQL** — relational database
* **Composer** — PHP dependency manager
* **Node.js & Vite** — frontend build & assets pipeline
* **Mailtrap/SMTP** — email testing for booking confirmations

---

## 📜 License

This project is licensed under the **MIT License**.

---

👨‍💻 Developed by [Ipangbbd](https://github.com/Ipangbbd)

```
```
