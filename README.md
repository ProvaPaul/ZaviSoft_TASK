# Multi Login System + Inventory Management System

**Laravel 10 | PHP 8.2 | MySQL | OAuth2 Passport | Double-Entry Accounting**

---

## Task 1: Multi Login SSO

- **ecommerce-app** (Port 8000) — OAuth2 Authorization Server (Laravel Passport)
- **foodpanda-app** (Port 8001) — OAuth2 Client

**SSO Flow:** Login at Ecommerce → Click "Go to Foodpanda" → Auth code exchanged for token → Auto-login. Logout from Foodpanda redirects back to Ecommerce.
## 🎥 Project Demo

<h2 align="center">🎬 Task 1 – Project VIDEO</h2>

<p align="center">
  <a href="https://youtu.be/FK4RAzQvzto">
    <img src="https://img.youtube.com/vi/FK4RAzQvzto/0.jpg" width="700">
  </a>
</p>
### Setup

```bash
cd Task1/ecommerce-app
composer install && cp .env.example .env && php artisan key:generate
php artisan migrate && php artisan db:seed && php artisan passport:install
php artisan serve

cd Task1/foodpanda-app
composer install && cp .env.example .env && php artisan key:generate
php artisan migrate && php artisan serve
```

> Set `ECOMMERCE_CLIENT_SECRET` in foodpanda `.env` from passport:install output.

**Demo:** `provapaul123@gmail.com` / `password`

---

## Task 2: Inventory Management 
<h2 align="center">🎬 Task 2 – Inventory Management System Project VIDEO</h2>

<p align="center">
  <a href="https://youtu.be/v_WujjnKLb4">
    <img src="https://img.youtube.com/vi/v_WujjnKLb4/0.jpg" width="700">
  </a>
</p>
- Product CRUD (Create, Read, Update, Delete)
- Sales with Discount & VAT calculation
- Double-Entry Accounting (Journal Entries — balanced debits & credits)
- Date-wise Financial Report (Total Sell, Total Expense with date filter)
- Dashboard with summary cards

### Setup

```bash
cd Task2/inventory-management-system
composer install && cp .env.example .env && php artisan key:generate
php artisan migrate && php artisan db:seed --class=ProductSeeder
php artisan serve
```

---

**Links:** Ecommerce http://127.0.0.1:8000 | Foodpanda http://127.0.0.1:8001 | Inventory http://127.0.0.1:8002

**Tech:** Laravel 10 · PHP 8.2 · MySQL · Passport · Tailwind · Bootstrap 5 · Blade · Vite
