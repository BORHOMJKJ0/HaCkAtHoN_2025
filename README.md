# HaCkAtHoN_2025 ✅

A Laravel-based REST API for the HaCkAtHoN_2025 project — a lightweight chat & messaging backend with JWT authentication, OTP verification, Firebase integration, and auto-generated API documentation.

---

## 🚀 Quick overview

-   **Framework:** Laravel (PHP 8.1+)
-   **API style:** RESTful JSON
-   **Auth:** JWT (php-open-source-saver/jwt-auth) + OTP email verification
-   **Realtime / Push:** Firebase / FCM (via kreait/laravel-firebase)
-   **API docs:** Swagger (l5-swagger) — see `/api/documentation` or generate with artisan

---

## 📋 Table of contents

-   [Features](#-features)
-   [Tech stack](#-tech-stack)
-   [Getting started](#-getting-started)
    -   [Prerequisites](#-prerequisites)
    -   [Install & run](#-install--run)
    -   [Environment variables](#-environment-variables)
-   [API documentation](#-api-documentation)
-   [Testing](#-testing)
-   [Project structure](#-project-structure)
-   [Contributing](#-contributing)
-   [License](#-license)
-   [Contact](#-contact)

---

## ✅ Features

-   User registration, login, password reset and email OTP verification
-   JWT-based authentication and token refresh endpoints
-   Resourceful APIs for Chats and Messages
-   Type endpoints (read-only) for chat categories
-   Push notifications via Firebase FCM
-   Swagger/OpenAPI auto-generated documentation
-   Database migrations & seeders for easy setup

---

## 🔧 Tech stack

-   PHP 8.1+
-   Laravel 10
-   MySQL / MariaDB (or any supported DB)
-   Redis (optional — for queue/ caching)
-   npm + Vite for frontend assets (if needed)
-   l5-swagger for API docs

---

## 🏁 Getting started

### Prerequisites

-   PHP 8.1 or higher
-   Composer
-   Node.js (18+) & npm
-   MySQL or other supported DB

### Install & run (development)

1. Clone the repo

    ```bash
    git clone <repo-url> && cd HaCkAtHoN_2025
    ```

2. Install PHP dependencies

    ```bash
    composer install
    ```

3. Install JS dependencies (if you need assets)

    ```bash
    npm install
    npm run dev
    ```

4. Copy and configure environment

    ```bash
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:secret
    ```

5. Set database credentials in `.env`, then migrate & seed

    ```bash
    php artisan migrate --seed
    ```

6. (Optional) Generate Swagger docs and publish assets

    ```bash
    php artisan l5-swagger:generate
    ```

7. Serve the app

    ```bash
    php artisan serve
    # or use your preferred server / Docker / Sail
    ```

---

## ⚙️ Environment variables (important)

Update `.env` with values for:

-   DB\_... (database connection)
-   JWT_SECRET (use `php artisan jwt:secret`)
-   MAIL\_... (SMTP config for OTP emails)
-   FIREBASE credentials (service account / keys) if using push notifications
-   FCM configuration if applicable

> Tip: Keep secrets out of the repository and use environment variables or secrets manager for production.

---

## 📘 API documentation

The project uses l5-swagger to publish OpenAPI docs.

-   Generate docs: `php artisan l5-swagger:generate`
-   Browse docs (when running locally): `http://localhost:8000/api/documentation`
-   A generated snapshot is also available at `storage/api-docs/api-docs.json`

API highlights (examples):

-   POST /api/users/register — register new user
-   POST /api/users/login — login and receive JWT token
-   GET /api/chats — list chats (requires Authorization header)

Example: login and use token

```bash
curl -X POST "http://localhost:8000/api/users/login" -H "Content-Type: application/json" -d '{"email":"user@example.com","password":"password"}'
# response: { "token": "<jwt>", ... }
# use token
curl -H "Authorization: Bearer <jwt>" http://localhost:8000/api/chats
```

---

## 🧪 Testing

Run the test suite with PHPUnit / artisan test:

```bash
php artisan test
# or
./vendor/bin/phpunit
```

Automated tests and factories are located in the `tests/` and `database/factories/` folders.

---

## 🗂 Project structure

Key folders:

-   `app/Http/Controllers` — controllers (Users, Chats, Messages, Types)
-   `app/Models` — Eloquent models
-   `app/Services` — service layer (FCM, etc.)
-   `routes/api.php` — API routes (main entrypoint for endpoints)
-   `database/migrations` & `seeders` — database schema & sample data
-   `storage/api-docs` — generated OpenAPI JSON

---

## 🤝 Contributing

Contributions are welcome. Please:

1. Fork the repo
2. Create a feature branch
3. Submit a PR with tests and clear description

Please follow PSR-12 and run `composer test` / `php artisan test` before opening PRs.

---

## 📜 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file.

---

## ✉️ Contact

For questions or support, open an issue or contact the maintainers.

---

Happy hacking! 🎯

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.
