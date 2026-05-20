# 🎟️ EventHub — Event Management System

A full-stack **Event Management** web application built with **Laravel 11** + **MongoDB** + **Tailwind CSS**.

## ✨ Features

### 🌐 Public
- Modern landing page with hero search bar
- Browse, search & filter events (by name, category, city, when)
- Featured events showcase
- Detailed event page with venue, price, and live seat availability

### 👤 Authentication & Roles
Three role types:
| Role        | Capabilities                                                    |
|-------------|-----------------------------------------------------------------|
| `admin`     | Full access: manage users, categories, all events               |
| `organizer` | Create / edit / delete own events, view bookings                |
| `attendee`  | Browse, book tickets, view bookings, cancel                     |

Users pick their role at registration (attendee/organizer). Admin role is assigned by other admins.

### 🎤 Organizer
- Create / Edit / Delete events with image upload
- Set capacity, price, dates, category, status (draft/published/cancelled)
- Mark events as ⭐ Featured
- Dashboard with stats: events, tickets sold, revenue

### 🎟️ Attendee
- Book 1–10 tickets per event
- Auto-generated unique ticket code
- View / cancel bookings
- Personalized dashboard with recommendations

### 🛡️ Admin
- Manage all users (change roles, delete)
- Manage categories
- Platform-wide stats: revenue, totals, latest activity

## 🛠️ Tech Stack
- **Backend:** Laravel 11 + PHP 8.2
- **Database:** MongoDB (via `mongodb/laravel-mongodb` v5)
- **Frontend:** Blade + Tailwind CSS (via CDN)
- **Storage:** Local disk (`storage/app/public`) for event images

## 📦 Setup (Windows / XAMPP)

### Prerequisites
1. **PHP 8.2+** (already in XAMPP)
2. **Composer** ✅
3. **MongoDB Server** — install from https://www.mongodb.com/try/download/community (default port `27017`)
4. **PHP MongoDB extension** — see below ⚠️

### Step 1 — Enable the PHP MongoDB extension (REQUIRED)
The `ext-mongodb` PHP extension is **not yet installed** in your XAMPP. Without it the app will not connect to the database.

1. Download `php_mongodb.dll` matching your PHP build:
   - Your PHP: `8.2 TS x64` (Thread Safe, 64-bit)
   - From: https://pecl.php.net/package/mongodb (pick the latest **8.2 Thread Safe x64** Windows DLL)
2. Place `php_mongodb.dll` in `C:\xampp\php\ext\`
3. Open `C:\xampp\php\php.ini` and add this line near the other `extension=` lines:
   ```ini
   extension=mongodb
   ```
4. Save & restart Apache (or just re-open PowerShell). Verify:
   ```powershell
   php -m | findstr mongodb
   ```

### Step 2 — Start MongoDB
Make sure MongoDB is running locally on `127.0.0.1:27017`. If installed as a Windows service, it auto-starts. Otherwise:
```powershell
mongod --dbpath C:\data\db
```

### Step 3 — Seed sample data
```powershell
php artisan db:seed
```

This creates 3 demo accounts (password: `password` for all):
- **Admin:**     `admin@eventhub.test`
- **Organizer:** `organizer@eventhub.test`
- **Attendee:**  `attendee@eventhub.test`

…plus 6 categories and 8 sample events.

### Step 4 — Run the dev server
```powershell
php artisan serve
```
Open http://localhost:8000 🎉

## 🗂️ Project Structure
```
app/
  Http/
    Controllers/
      AuthController.php
      BookingController.php
      DashboardController.php
      EventController.php
      HomeController.php
      Admin/CategoryController.php
      Admin/UserController.php
    Middleware/RoleMiddleware.php
  Models/
    User.php       (extends MongoDB\Laravel\Auth\User)
    Category.php
    Event.php
    Booking.php
config/database.php   # MongoDB connection added
routes/web.php
resources/views/
  layouts/app.blade.php
  home.blade.php
  auth/{login,register}
  events/{show, partials/card}
  bookings/{create,show,index}
  organizer/events/{index,create,edit,_form}
  admin/{categories/index, users/index}
  dashboard/{admin,organizer,attendee}
database/seeders/DatabaseSeeder.php
```

## 🧩 MongoDB Collections
- `users` — name, email, password (hashed), role, phone
- `categories` — name, slug, icon (emoji), description
- `events` — title, description, venue, city, starts_at, ends_at, price, capacity, seats_booked, image, status, category_id, organizer_id, is_featured
- `bookings` — user_id, event_id, tickets, total_amount, status, ticket_code, attendee_name/email/phone

## 🐛 Troubleshooting

**"Class MongoDB\Driver\Manager not found"** → `ext-mongodb` is not enabled. Re-do Step 1.

**Connection refused** → MongoDB server isn't running. Start `mongod`.

**Pagination doesn't work** → MongoDB pagination on this package uses `paginate()` which is supported; ensure your collection has data.

**Image upload not visible** → `php artisan storage:link` (already done).

---
Built with ❤️ using Laravel 11 + MongoDB
