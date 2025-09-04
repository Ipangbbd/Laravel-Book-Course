# 📌 Backend Development To-Do List

This document outlines the 1-week development plan to complete the backend for **Laravel Course Booking**.

---

## 🗓 Development Roadmap

### **Day 1 – Setup & Authentication**

* [x] Configure environment (`.env`, database connection).
* [x] Implement authentication (login & register) with role separation (Admin & Student).
* [x] Apply middleware for `admin.php` routes.
* [x] Test basic authentication flow.

---

### **Day 2 – Database & Models**

* [x] Review and finalize all migrations (users, categories, instructors, courses, schedules, bookings).
* [x] Define Eloquent relationships:

  * `User` ↔ `Booking`
  * `Course` ↔ `Category`
  * `Course` ↔ `Instructor`
  * `Course` ↔ `Schedule`
* [x] Create factories and seeders for dummy data.
* [x] Run migrations and seed database.

---

### **Day 3 – Admin: Course Management**

* [ ] Complete **Admin\CourseController** with full CRUD.
* [ ] Add form validation with `StoreCourseRequest` & `UpdateCourseRequest`.
* [ ] Enable course thumbnail upload (optional).
* [ ] Ensure relation handling with Category & Instructor.

---

### **Day 4 – Admin: Schedule & Booking Management**

* [ ] Implement **Admin\ScheduleController** (CRUD for schedules).
* [ ] Implement **Admin\BookingController**:

  * View all bookings.
  * Update booking status (pending, confirmed, canceled).
* [ ] Verify Course ↔ Schedule ↔ Booking consistency.

---

### **Day 5 – Public: Course & Booking**

* [ ] Implement **Public\CourseController**:

  * `index()` → list courses.
  * `show()` → course details with schedule.
* [ ] Implement **Public\BookingController**:

  * Booking form submission.
  * Validate with `StoreBookingRequest`.
  * Redirect to success page.

---

### **Day 6 – API Endpoints (Optional but Recommended)**

* [ ] Setup `api.php` routes for JSON API.
* [ ] Endpoints:

  * `GET /courses`, `GET /courses/{id}`
  * `POST /bookings`
  * `GET /bookings/{user}`
* [ ] Use Laravel API Resources for structured responses.
* [ ] Add authentication via Sanctum/JWT (if required).

---

### **Day 7 – Polishing & Testing**

* [ ] Perform end-to-end testing for Admin & Public flows.
* [ ] Strengthen request validations.
* [ ] Implement error handling and flash messaging.
* [ ] Add booking notification email (if time allows).
* [ ] Document routes and API endpoints.

---

## ✅ Deliverables by End of Week

* Functional backend for course booking system.
* Admin dashboard to manage courses, schedules, instructors, and bookings.
* Public booking system with confirmation.
* Optional API endpoints for integration with mobile/SPA.
