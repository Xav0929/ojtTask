<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Task Manager

A task manager built with Laravel. Users can register, log in, and manage their own tasks. Each task belongs to a category (Work, School, Personal) and has a title, description, priority, status (pending/done), and due date.

## Frameworks and Template Used

- **Backend framework:** [Laravel 13](https://laravel.com/)
- **Template engine:** [Laravel Blade](https://laravel.com/docs/blade)
- **Frontend framework/template:** [Bootstrap 5.3.3](https://getbootstrap.com/)
- **Template source:** [Bootstrap 5.3.3 CDN](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)
- **Database:** [PostgreSQL 17](https://www.postgresql.org/)
- **Version control:** Git and GitHub
- **Design:** Custom olive and cream layout based on a reference design (no external template link). Master layout: `resources/views/layouts/app.blade.php`
## Features

- Register, log in, and log out (passwords hashed)
- `guest` and `auth` middleware protecting all task routes
- Create, edit, delete, and view task details using Bootstrap modals
- Search, filter by category and status, and pagination
- Priority levels, overdue detection, and category color tags
- Mark done checkbox and select all
- Each user sees only their own tasks (403 on other users' tasks)


## Project Structure

- `routes/web.php`: routes and middleware groups
- `app/Http/Controllers/TaskController.php`: task CRUD, filters, mark done
- `app/Http/Controllers/AuthController.php`: login, register, logout
- `app/Models/`: `User`, `Task`, `Category`
- `database/migrations/`, `database/seeders/`, `database/factories/`
- `resources/views/layouts/app.blade.php`: master layout
- `resources/views/tasks/index.blade.php`: task list and modals
- `resources/views/auth/`: login and register pages

## Setup

1. Clone the repository
2. Install PHP packages: `composer install`
3. Copy `.env.example` to `.env`
4. Create a PostgreSQL database named `taskManager`
5. In `.env`, set `DB_CONNECTION=pgsql`, `DB_PORT=5432`, `DB_DATABASE=taskManager`, `DB_USERNAME` and `DB_PASSWORD`
6. Enable the `pdo_pgsql` and `pgsql` extensions in `php.ini`
7. Generate the app key: `php artisan key:generate`
8. Build and seed the database: `php artisan migrate:fresh --seed`
9. Start the server: `php artisan serve`

Then open http://127.0.0.1:8000

**Demo account:** `test@example.com` / `password`

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).