# Laravel Livewire CoreUI Starter

A Laravel starter project with Livewire and CoreUI integration, ready to use for rapid application development.

## Features

- Laravel 12.x
- Livewire 3.x
- CoreUI integration
- Pre-configured development environment
- Automated setup scripts

## Installation

Create a new project using Composer:

```bash
composer create-project your-vendor/livewire-laravel-coreui-starter {project_name} --stability=dev
```

Replace `{project_name}` with your desired project name.

### Manual Installation

If you prefer to clone the repository:

```bash
git clone https://github.com/your-username/livewire-laravel-coreui-starter.git {project_name}
cd {project_name}
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

## Quick Start

After installation, run the development server:

```bash
composer run dev
```

This will start:
- Laravel development server
- Queue worker
- Log viewer (Pail)
- Vite dev server

## Testing

Run tests with:

```bash
composer test
```

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- Database (MySQL, PostgreSQL, SQLite, etc.)

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
