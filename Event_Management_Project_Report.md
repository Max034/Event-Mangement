# Event Management System - Project Report

## 1. Introduction
The **Event Management System** is a robust, web-based application designed to facilitate the creation, management, and booking of events. The system caters to multiple user roles, providing an intuitive interface for event organizers to list their events, and for attendees to securely book tickets and manage their reservations.

## 2. Technology Stack
- **Backend Framework:** Laravel (PHP)
- **Database:** MongoDB (integrated via `mongodb/laravel-mongodb` package)
- **Authentication:** Laravel's built-in authentication system
- **Frontend/Views:** Laravel Blade Templates

## 3. System Architecture & Models
The system uses the Model-View-Controller (MVC) architectural pattern, keeping business logic, data presentation, and routing cleanly separated.

### Core Entities (MongoDB Collections)
1. **Users:** Handles system authentication and role-based access. Users can act as regular attendees or event organizers (or administrators).
2. **Events:** Stores comprehensive details about an event, including title, slug, description, venue, address, city, schedule (`starts_at`, `ends_at`), pricing, capacity, and the number of currently booked seats. Events also feature image uploads and statuses (`draft`, `published`, `cancelled`).
3. **Categories:** Organizes events into specific themes or genres, helping users filter and discover events easily.
4. **Bookings:** Tracks ticket reservations. Each booking is linked to a user and an event, storing the number of tickets, total amount, attendee details, a unique randomly generated `ticket_code`, and the booking status.

## 4. Key Features

### 4.1 Role-Based Access Control
- **Attendees:** Can browse events, book tickets, view their booking history, and cancel active bookings if needed.
- **Organizers:** Can access a dedicated dashboard to create new events, update existing event details, upload event banners/images, and track how many seats have been booked.
- **Administrators:** Possess global privileges to manage any user's events or bookings and monitor the entire system's activity.

### 4.2 Event Management
- **Creation & Publishing:** Organizers can draft events, providing detailed information such as venue, price, and capacity. The application automatically generates SEO-friendly slugs for event URLs.
- **Capacity Tracking:** The system dynamically calculates available seats using `seatsRemaining()` and strictly prevents overbooking. It also determines if an event is upcoming or sold out.
- **Image Handling:** Seamless handling of event banner image uploads using Laravel's local storage capabilities.

### 4.3 Secure Booking System
- **Real-Time Seat Allocation:** When a user initiates a booking, the system validates the requested ticket count against the remaining capacity. Upon successful validation, it records the booking and increments the `seats_booked` property on the Event model.
- **Ticket Codes:** Every confirmed booking is assigned a unique, randomly generated 10-character alphanumeric ticket code for verification purposes.
- **Cancellation Flow:** Users can cancel their bookings. Upon cancellation, the system updates the booking status and decrements the event's booked seat count, immediately freeing up capacity for other attendees.

## 5. Conclusion
The Event Management System provides a highly scalable and flexible solution for event coordination by leveraging the rapid development capabilities of Laravel and the document-oriented flexibility of MongoDB. Its robust booking logic ensures data consistency and provides a seamless user experience for both organizers and attendees.
