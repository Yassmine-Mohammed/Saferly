# Safarly ✈️

**Safarly** is a tourism platform that connects travelers with tourism companies. Travelers can search for trips, compare offers, and book directly, while companies manage their own trips and bookings, and admins keep the platform trustworthy.

---

## Table of Contents

- [Features](#features)
- [User Roles](#user-roles)
- [Tech Stack](#tech-stack)
- [Workflow](#workflow)
- [Database Schema](#database-schema)
- [Security](#security)
- [Getting Started](#getting-started)
- [Project Structure](#project-structure)
- [Team](#team)

---

## Features

- **Authentication**: register and log in with role-based access.
- **Smart search**: find trips by destination, budget, dates, and preferences.
- **Compare & book**: view trip details, compare offers from different companies, and send booking requests.
- **Company dashboard**: tourism companies can create, read, update, and delete (CRUD) their trips and accept or reject bookings.
- **Reviews & favorites**: travelers can rate trips and save the ones they like.
- **Admin moderation**: admins monitor activity and verify companies.

## User Roles

| Role | What they can do |
|------|------------------|
| **Traveler** | Search trips, view details, book, review, save favorites |
| **Tourism Company** | Manage trips (CRUD), accept/reject bookings |
| **Admin** | Verify companies, moderate users, trips, and reviews |

> New companies start with the status `not_verified`. Only the admin can change a company's status (e.g. to `active`).

## Tech Stack

- **Front-end:** HTML5, CSS3, Bootstrap, JavaScript
- **Back-end:** PHP
- **Database:** MySQL

## Workflow

```
Register → Login → Search → Trip Details → Booking → Company accepts → Admin monitors
```

## Database Schema

| Table | Purpose |
|-------|---------|
| `users` | All accounts (travelers, companies, admins) |
| `companies` | Tourism company profiles and verification status |
| `trips` | Trips published by companies |
| `bookings` | Traveler booking requests and their status |
| `reviews` | Traveler ratings and comments |
| `favorites` | Trips saved by travelers |

## Security

- Session-based authentication and role-based authorization
- Server-side input validation
- Prepared statements to prevent SQL injection
- Passwords hashed with `password_hash()` and checked with `password_verify()`

## Getting Started

### Prerequisites

- PHP 8+ and MySQL (e.g. via [XAMPP](https://www.apachefriends.org/) or WAMP)
- A web browser

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Yassmine-Mohammed/Saferly.git
   cd Saferly
   git checkout yassmine
   ```

2. **Move the project** into your server's root folder (e.g. `htdocs` for XAMPP).

3. **Create the database**
   - Open phpMyAdmin and create a database (e.g. `safarly`).
   - Import the provided `.sql` file.

4. **Configure the connection**
   - Update the database credentials in the config/connection file (host, username, password, database name).

5. **Run it**
   - Start Apache and MySQL, then open `http://localhost/Saferly` in your browser.


⭐ If you like the project, give it a star!
