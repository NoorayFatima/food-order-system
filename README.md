# food-order-system
A PHP-based restaurant food ordering system with admin panel

# Food Order System 🍔🍕🍜

A simple PHP & MySQL based restaurant food ordering system with admin panel.

## 🚀 Features

- Admin Login
- Add/Edit/Delete Categories & Foods
- Place and manage customer orders
- Fully responsive layout using CSS
- MySQL database integration

## 📂 Project Structure

- `/admin` — Admin dashboard
- `/images` — Food and category images
- `/config` — Database configuration
- `index.php` — Homepage
- `login.php` — Admin login

## 🔧 Installation Instructions

1. Clone this repository or download the ZIP
2. Place the folder in `htdocs` (if using XAMPP)
3. Import the `database/restaurant.sql` file into your MySQL database
4. Update `config/constants.php` with your DB credentials

```php
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'restaurant');

