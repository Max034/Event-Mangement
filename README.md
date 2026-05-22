<div align="center">
  <h1>🎟️ EventHub</h1>
  <p>A modern, full-stack Event Management platform built with Laravel, MongoDB, and Tailwind CSS.</p>

  <p>
    <a href="https://laravel.com/"><img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
    <a href="https://www.mongodb.com/"><img src="https://img.shields.io/badge/MongoDB-4EA94B?style=for-the-badge&logo=mongodb&logoColor=white" alt="MongoDB"></a>
    <a href="https://tailwindcss.com/"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
    <a href="https://vercel.com/"><img src="https://img.shields.io/badge/Vercel-000000?style=for-the-badge&logo=vercel&logoColor=white" alt="Vercel"></a>
    <a href="https://cloudinary.com/"><img src="https://img.shields.io/badge/Cloudinary-3448C5?style=for-the-badge&logo=cloudinary&logoColor=white" alt="Cloudinary"></a>
  </p>
</div>

---

## 🚀 Live Demo

*(Add your Vercel URL here in your repository settings "Website" field!)*
**Live Application:** [Your Vercel Link Here]

> **Note for Repository Owner:** *Take some beautiful screenshots of your app's home page and dashboard, save them in a folder called `docs/` or `images/` in this repo, and drag them right here into the README to show off your work!*

---

## ✨ Key Features

### 🌐 Public Experience
- **Modern Landing Page**: Clean, responsive hero section with a quick search bar.
- **Dynamic Browsing**: Search and filter events seamlessly by name, category, city, or date.
- **Featured Highlights**: A curated list of top-tier featured events.
- **Deep Dives**: Detailed event pages showcasing venue information, ticket pricing, and live seat availability.

### 👤 Role-Based Access Control
| Role        | Capabilities |
|-------------|--------------|
| **Admin**     | Full access to the platform. Manages all users, categories, and platform-wide events. |
| **Organizer** | Creates, edits, and manages their own events. Has access to a dashboard for tracking ticket sales and attendees. |
| **Attendee**  | Browses events, books tickets, manages their active bookings, and receives unique ticket codes. |

### 🎤 Organizer Tools
- **Effortless Event Creation**: Create and manage events with rich details and direct image uploads via Cloudinary.
- **Customizable**: Set capacity limits, prices, dates, categories, and publish statuses.
- **Analytics Dashboard**: Track events, total tickets sold, and incoming revenue at a glance.

### 🎟️ Attendee Portal
- **Ticket Booking**: Seamlessly book up to 10 tickets per event.
- **Ticket Generation**: Receive an automatically generated, unique ticket code for every booking.
- **Personalized Dashboard**: View past and upcoming bookings, with options to cancel if needed.

---

## 🛠️ Tech Stack Architecture
- **Backend Framework**: Laravel 11 (PHP 8.2+)
- **Database**: MongoDB (Integrated via `mongodb/laravel-mongodb` v5)
- **Frontend Styling**: Blade Templating + Tailwind CSS
- **Cloud Storage**: Cloudinary SDK (For fast, persistent event image hosting)
- **Deployment**: Serverless deployment configured for Vercel

---

## 📦 Local Development Setup

If you want to run this project locally, follow these steps:

### Prerequisites
1. **PHP 8.2+** 
2. **Composer** installed.
3. **MongoDB** installed and running locally on port `27017`.
4. The `ext-mongodb` PHP extension enabled in your `php.ini`.

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Max034/Event-Mangement.git
   cd Event-Mangement
   ```

2. **Install Composer dependencies:**
   ```bash
   composer install
   ```

3. **Set up your environment:**
   Copy the example environment file and set your keys.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure to add your MongoDB connection and Cloudinary URL in your `.env` file.*

4. **Seed the database (Optional but recommended):**
   ```bash
   php artisan db:seed
   ```
   *Creates demo accounts (Admin, Organizer, Attendee) with password `password`, plus categories and sample events.*

5. **Start the local server:**
   ```bash
   php artisan serve
   ```
   Your app will be available at `http://localhost:8000`.

---
<div align="center">
  <i>Built with ❤️ using Laravel & MongoDB</i>
</div>
