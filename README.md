# SME Invoice & Quotation System

A professional invoice and quotation management system built with Laravel 12 and Livewire, designed specifically for Small and Medium Enterprises (SMEs) in Singapore.

---

## Features

- 📋 **Customer Management** — Store customer details, track invoice history
- 💰 **Invoicing** — Create professional invoices with automatic numbering
- 📝 **Quotations** — Generate quotes and convert them to invoices
- 🧾 **PDF Generation** — Export invoices and quotations as PDF documents
- 💵 **SGD Currency** — Built-in Singapore Dollar formatting with 9% GST calculation
- 📊 **Dashboard** — View revenue statistics and recent activity at a glance
- 🎨 **Clean UI** — Professional, responsive design using Tailwind CSS

---

## Tech Stack

- **Backend**: Laravel 12.53.0 (PHP 8.4)
- **Frontend**: Livewire 4.2.0 + Tailwind CSS 4.0
- **Database**: SQLite (local development), PostgreSQL (production on Render)
- **Authentication**: Laravel Fortify
- **Build Tool**: Vite 7.3

---

## Requirements

- PHP 8.4 or higher
- Composer 2.x
- Node.js 18+ and npm
- SQLite (for local development)

---

## Local Setup

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/sme-invoice-app.git
cd sme-invoice-app
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Configure Environment
```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Set Up Database
```bash
# Run migrations to create database tables
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed
```

### 6. Build Frontend Assets
```bash
npm run build
```

### 7. Start Development Server
```bash
# Terminal 1: Start PHP server
php artisan serve

# Terminal 2: Start Vite dev server (for hot-reload)
npm run dev
```

Visit **http://localhost:8000** in your browser.

---

## Development Workflow

### Running the App
- **PHP server**: `php artisan serve` (runs on http://localhost:8000)
- **Asset compilation**: `npm run dev` (hot-reload for CSS/JS changes)

### Database Commands
```bash
# Run new migrations
php artisan migrate

# Reset database (CAUTION: deletes all data)
php artisan migrate:fresh

# Seed sample data
php artisan db:seed
```

### Debugging
```bash
# Interactive PHP console
php artisan tinker

# List all routes
php artisan route:list

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Deployment (Render + Neon PostgreSQL)

This project is configured for free-tier deployment on **Render** (hosting) + **Neon** (PostgreSQL database).

### Prerequisites
1. GitHub account (code repository)
2. Render account (free): https://render.com
3. Neon account (free): https://neon.tech

### Quick Deploy Steps
1. Push code to GitHub
2. Create Neon Postgres database → copy connection string
3. Create Web Service on Render:
   - Connect GitHub repository
   - Set environment variables (see `.env.example`)
   - Add Neon database URL to `DATABASE_URL`
4. Render auto-deploys on every push to `main` branch

**Note**: Free tier has cold starts (~30-60s first load after inactivity).

Detailed deployment instructions will be added in a separate deployment guide.

---

## Project Structure

```
sme-invoice-app/
├── app/
│   ├── Http/Controllers/  # Web request handlers
│   ├── Livewire/          # Interactive components
│   └── Models/            # Database models
├── database/
│   ├── migrations/        # Database schema
│   └── seeders/           # Sample data
├── resources/
│   ├── css/               # Tailwind CSS
│   ├── js/                # JavaScript entry point
│   └── views/             # Blade templates
├── routes/
│   └── web.php            # Route definitions
├── public/                # Public assets (images, compiled CSS/JS)
└── storage/               # Uploads, logs, cache
```

---

## Customization

See **[HOW_TO_CUSTOMIZE.md](./HOW_TO_CUSTOMIZE.md)** for detailed guidance on:
- Adding new pages and features
- Modifying Livewire components
- Changing company branding (logo, colors)
- Adding database fields
- Common Laravel commands

---

## Git Workflow

See **[GIT_CHEATSHEET.md](./GIT_CHEATSHEET.md)** for:
- Basic git commands
- How to undo mistakes
- Render auto-deploy process

---

## Documentation

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [Livewire 4 Documentation](https://livewire.laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

---

## License

This project is open-source software built for freelance portfolio purposes.

---

## Support

For bugs or questions, open an issue on GitHub or contact the developer.

**Built for Singapore SMEs** 🇸🇬
