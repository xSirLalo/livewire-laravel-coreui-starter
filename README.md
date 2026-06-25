# Laravel Livewire CoreUI Starter

A Laravel starter project with Livewire and CoreUI integration, ready to use for rapid application development.

## Features

- Laravel 12.x
- Livewire 3.x
- CoreUI integration
- Pre-configured development environment
- Automated setup scripts
- Ready-to-use authentication system
- Livewire CRUD stubs for rapid development

## Installation

### Method 1: Create Project from GitHub (Recommended)

Create a new project directly from this repository using Composer:

```bash
composer create-project xsirlalo/livewire-laravel-coreui-starter my-project --repository='{"type":"vcs","url":"https://github.com/xsirlalo/livewire-laravel-coreui-starter"}'
```

This will automatically:
- Download the starter kit
- Install all Composer dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Create SQLite database
- Run migrations
- Install NPM dependencies
- Build frontend assets

### Method 2: Clone Repository

If you prefer to clone the repository manually:

```bash
git clone https://github.com/xsirlalo/livewire-laravel-coreui-starter.git my-project
cd my-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

## Configuration

After installation, configure your database and other settings in the `.env` file:

```env
DB_CONNECTION=sqlite
# Or use MySQL/PostgreSQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password
```

## Quick Start

After installation, run the development server:

```bash
composer run dev
```

This will start:
- Laravel development server (http://127.0.0.1:8000)
- Queue worker
- Log viewer (Pail)
- Vite dev server

Or run services individually:

```bash
php artisan serve          # Development server
php artisan queue:work     # Queue worker
php artisan pail           # Log viewer
npm run dev                # Vite dev server
```

## Testing

Run tests with:

```bash
composer test
```

Or run PHPUnit directly:

```bash
php artisan test
```

## Available Scripts

- `composer setup` - Full setup (install dependencies, generate key, migrate, build assets)
- `composer dev` - Run all development services concurrently
- `composer test` - Run PHPUnit tests

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM (v16 or higher)
- Database (MySQL, PostgreSQL, SQLite, etc.)
- Git

## Project Structure

- `app/Livewire/` - Livewire components
- `resources/views/` - Blade templates
- `resources/js/` - JavaScript files
- `resources/sass/` - SCSS files
- `routes/` - Application routes
- `stubs/` - Custom Livewire CRUD generation stubs

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
