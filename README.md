# VDSolutions - Renovation Company Website

A modern, professional website for a renovation company built with Laravel and Filament. This platform showcases services, manages projects, and provides an intuitive admin panel for content management.

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.0-38B2AC?logo=tailwind-css)
![Vite](https://img.shields.io/badge/Vite-8.0-646CFF?logo=vite)
![Filament](https://img.shields.io/badge/Filament-5.0-FB70A9?logo=filamentphp)
![CI](https://img.shields.io/badge/CI%2FCD-GitHub%20Actions-2088FF?logo=githubactions)

## 🏠 Project Overview

VDSolutions is a comprehensive web platform designed for a renovation company to:
- Showcase renovation services and portfolio projects
- Provide customer contact and inquiry management
- Offer an admin dashboard for managing content, media, and analytics
- Ensure security and performance with modern PHP practices

## ✨ Features

### Frontend
- Responsive design with Tailwind CSS 4
- Fast asset compilation using Vite
- Modern JavaScript with ES modules
- Custom theme with professional renovation aesthetics

### Backend
- Laravel 13 with robust MVC architecture
- Filament 5 admin panel for easy content management
- Media management with Spatie Media Library
- Analytics integration for tracking visitor data
- Honeypot spam protection for forms
- Database session and cache drivers

### Admin Panel (Filament)
- Intuitive dashboard for managing website content
- Media library for uploading and organizing project images
- User management and role-based access control
- Form submissions and inquiry management
- Analytics reports and insights

## 🛠 Tech Stack

### Core Framework
- **Laravel 13** - PHP web application framework
- **PHP 8.3** - Latest PHP version with performance improvements

### Frontend Tools
- **Vite** - Next-generation frontend tooling
- **Tailwind CSS 4** - Utility-first CSS framework
- **Axios** - Promise-based HTTP client

### Admin & CMS
- **Filament 5** - Beautiful admin panel builder
- **Spatie Laravel Media Library** - Media management
- **Spatie Laravel Analytics** - Google Analytics integration
- **Spatie Laravel Honeypot** - Spam prevention

### Development Tools
- **Laravel Pint** - PHP code style fixer
- **PHPUnit** - Testing framework
- **Concurrently** - Run multiple commands simultaneously
- **Faker** - Fake data generation

## 📦 Installation

### Prerequisites
- PHP 8.3 or higher
- Composer 2.5 or higher
- Node.js 18+ and npm 10+
- MySQL 8.0+ or MariaDB

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd vdsolutions
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Update `.env` with your database credentials and other settings.

5. **Run migrations and seed database**
   ```bash
   php artisan migrate --seed
   ```

6. **Build frontend assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Website: http://localhost:8000
   - Admin Panel: http://localhost:8000/admin (credentials set in database seeders)

### Quick Setup Script
Run the included setup script for a complete installation:
```bash
composer run setup
```

## 🚀 Development

### Running the Development Environment
Start all development services with a single command:
```bash
composer run dev
```

This command starts:
- Laravel development server
- Queue worker
- Log tailing
- Vite development server

For email testing, a Mailpit Docker service is available via `docker-compose up -d mailpit` (SMTP: 1025, web interface: http://localhost:8025).

### Available Commands
- `php artisan serve` - Start Laravel development server
- `npm run dev` - Start Vite development server
- `npm run build` - Build for production
- `php artisan test` - Run PHPUnit tests
- `php artisan pint` - Fix code style issues
- `php artisan migrate` - Run database migrations

## 🔧 Configuration

### Environment Variables
Key environment variables to configure:

```env
APP_NAME=VDSolutions
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vdsolutions
DB_USERNAME=root
DB_PASSWORD=

# Optional: Google Analytics
ANALYTICS_PROPERTY_ID=

# Optional: Mail configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
```

### Filament Configuration
The admin panel is configured in `app/Providers/FilamentServiceProvider.php`. Customize:
- Panel ID and path
- Brand name and logo
- Navigation items
- Resources and pages

## 📁 Project Structure

```
vdsolutions/
├── app/                  # Application core
│   ├── Filament/         # Filament resources
│   ├── Models/           # Eloquent models
│   └── Providers/        # Service providers
├── config/               # Configuration files
├── database/             # Migrations and seeders
├── public/               # Web root
├── resources/
│   ├── css/              # Tailwind CSS
│   ├── js/               # JavaScript files
│   └── views/            # Blade templates
├── routes/               # Application routes
└── tests/                # Test suites
```

## 🔌 Plugins & Packages

### Primary Packages
- **filament/filament** (^5.0) - Admin panel framework
- **filament/spatie-laravel-media-library-plugin** (^5.0) - Media integration
- **spatie/laravel-analytics** (^5.7) - Google Analytics wrapper
- **spatie/laravel-honeypot** (^4.7) - Spam protection

### Development Packages
- **laravel/pint** (^1.27) - PHP code style fixer
- **nunomaduro/collision** (^8.6) - Error handler
- **mockery/mockery** (^1.6) - Mocking library

## 🧪 Testing

Run the test suite:
```bash
composer test
```

Or use PHPUnit directly:
```bash
vendor/bin/phpunit
```

## 🔁 CI/CD

This project uses **GitHub Actions** for CI/CD checks on every push and pull request to `main`.

The workflow is defined in `.github/workflows/ci-cd.yml` and currently runs:
- Backend checks (Laravel migrations + automated tests)
- Frontend checks (Node dependency install + production asset build)

## 📊 Deployment

### Production Build
1. Run `npm run build` to compile assets
2. Set `APP_ENV=production` and `APP_DEBUG=false`
3. Configure proper database and cache drivers
4. Set up queue workers for background jobs

### Recommended Hosting
- **Laravel Forge** - Automated server management
- **Laravel Vapor** - Serverless deployment
- **Traditional VPS** with Nginx/PHP-FPM

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and ensure code quality
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🏢 About VDSolutions

VDSolutions is a professional renovation company specializing in home and commercial renovations. This website represents our commitment to quality, transparency, and customer satisfaction in every project we undertake.

---

**Built with ❤️ using modern web technologies**
