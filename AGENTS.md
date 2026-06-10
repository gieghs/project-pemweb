# White North Store — AGENTS.md

## Stack
- **Laravel 12** + **Blade** (Inertia installed but **not** used for rendering — all views are `@extends('layouts.*')`)
- **Tailwind CSS v4** via `@tailwindcss/vite` plugin
- **Vite** with `laravel-vite-plugin` (entry: `resources/css/app.css`, `resources/js/app.js`)

## Setup & Dev
```bash
composer setup          # full fresh install (composer install → .env → key → migrate → npm install → build)
composer dev            # runs 4 processes: artisan serve + queue:listen + pail + vite (concurrently)
composer test           # config:clear → php artisan test
npm run build           # vite build
npm run dev             # vite dev server
```

## Database
- **Local**: MySQL (`whitenorth_db` on root:3306, no password) — actual `.env`
- **Testing**: SQLite `:memory:` — see `phpunit.xml`
- Migrations: 13 files; run `php artisan migrate` after cloning

## Auth & Roles
- **Custom auth** (`AuthController`) — login accepts email OR username (auto-detected via `FILTER_VALIDATE_EMAIL`)
- Role column on `users` table: `'user'` or `'admin'` — checked via `$user->isAdmin()`
- **Admin middleware**: alias `'admin'` → `EnsureUserIsAdmin` (aborts 403 if not admin)
- **Admin login redirects to `/admin/orders`**, not `/admin`
- **`RedirectAdminToDashboard` middleware** is defined but **not registered** in `bootstrap/app.php`

## Seeders
- `DatabaseSeeder` — comprehensive (users, products, cart, orders, reviews, negotiations)
- `ProductSeeder` — just 10 products (calls `Product::truncate()`)
- Admin credentials: `admin@whitenorthstore.com` / `admin 123`
- **Bug**: `DatabaseSeeder` imports `App\Models\Negotiation` — the model file does not exist; the seeder will crash if run as-is

## Architecture Notes
- **View Composer** in `AppServiceProvider::boot()` injects `$globalCart` into every Blade view
- **Cart items** have only `product_id` + `user_id` — no `quantity` column (always 1 per entry; multiple rows for multiple items)
- **Session**: `file` driver (actual .env); **Cache/Queue**: `database` driver
- **Payment**: Manual transfer (BCA/QRIS) only — no payment gateway
- **Shipping**: Uses Komerce API (RajaOngkir wrapper) — requires `KOMERCE_SHIPPING_KEY` in `.env`
- `HandleInertiaRequests` middleware is registered in `bootstrap/app.php` but only shares data — **all views are Blade**, not Inertia
- CSRF token in `<meta name="csrf-token">` for AJAX cart operations
- Review popup triggers after purchase if user hasn't reviewed
- **UI language**: Indonesian (UI strings), English (code/DB)

## Tests
- Uses `phpunit` — no pest
- `phpunit.xml` sets `DB_CONNECTION=sqlite` with `DB_DATABASE=:memory:`
- Only example tests exist (`tests/Feature/ExampleTest.php`, `tests/Unit/ExampleTest.php`)
- Factories: only `UserFactory` exists — no Product/CartItem/Order/Review factories
