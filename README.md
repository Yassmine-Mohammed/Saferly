# Safarly

Safarly is a PHP and MySQL travel booking website. Visitors can explore and compare trips; registered users can book trips, manage favorites, and leave reviews. The project also includes company and admin pages for managing trips, users, and bookings.

## Requirements

- PHP 8.2 or later with MySQLi enabled
- MySQL or MariaDB
- Apache (XAMPP is suitable)

## Run locally with XAMPP

1. Copy or clone the project into XAMPP's `htdocs` directory.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Open phpMyAdmin, create a database named `safarly`, and import [`Database/safarly.sql`](Database/safarly.sql).
4. Configure the database connection in [`config/db.php`](config/db.php) for your local database. Use your local host, database name, username, and password. Keep credentials private; do not commit real passwords to source control.
5. Open the project in your browser. For example, if the project directory is `htdocs/Saferly`, visit `http://localhost/Saferly/`.

The SQL file creates the database tables and indexes. It does not provide demo accounts or trip data.

## Main folders

- `admin/` — admin management pages
- `auth/` — registration, login, and user profile pages
- `booking/` — booking, trip details, favorites, and reviews
- `company/` — company dashboard and trip management
- `search/` — trip search, filters, and comparison
- `Database/` — database schema
- `assets/`, `includes/`, `css/`, `js/` — images, shared PHP files, styles, and scripts

