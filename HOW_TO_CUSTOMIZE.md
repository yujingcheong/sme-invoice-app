# How to Customize This Project

This guide will help you customize and extend the SME Invoice & Quotation System. It's written for developers who know HTML, CSS, and PHP but are new to Laravel.

---

## Project Directory Structure

Here's what each folder does:

```
sme-invoice-app/
├── app/                    # Your application code
│   ├── Http/
│   │   └── Controllers/   # Handle web requests (rarely used with Livewire)
│   ├── Livewire/          # Livewire components (your main work area)
│   └── Models/            # Database models (Customer, Invoice, etc.)
├── bootstrap/             # Laravel startup files (don't modify)
├── config/                # Configuration files (database, app settings)
├── database/
│   ├── migrations/        # Database schema changes
│   └── seeders/           # Sample data generators
├── public/                # Publicly accessible files (CSS, JS, images)
│   └── storage/           # Symbolic link to storage/app/public
├── resources/
│   ├── css/               # Tailwind CSS source
│   ├── js/                # JavaScript (Livewire initialization)
│   └── views/             # Blade templates (HTML with PHP)
├── routes/
│   └── web.php            # Define URL routes
├── storage/               # File uploads, logs, cache
│   └── app/public/        # User-uploaded files
├── vendor/                # Composer dependencies (don't modify)
├── .env                   # Environment config (database, app key)
├── artisan                # Command-line tool
└── composer.json          # PHP package list
```

**Key folders you'll work in:**
- `app/Livewire/` — Build interactive components here
- `app/Models/` — Define database tables and relationships
- `resources/views/` — Create HTML templates
- `routes/web.php` — Map URLs to components/views

---

## How to Add a New Page

Let's say you want to add a `/reports` page.

### Step 1: Create a Livewire Component

Run this command:
```bash
php artisan make:livewire Reports
```

This creates two files:
- `app/Livewire/Reports.php` (component logic)
- `resources/views/livewire/reports.blade.php` (HTML template)

### Step 2: Add Data Logic

Edit `app/Livewire/Reports.php`:
```php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;

class Reports extends Component
{
    public function render()
    {
        $totalRevenue = Invoice::where('status', 'paid')->sum('total');
        
        return view('livewire.reports', [
            'totalRevenue' => $totalRevenue
        ]);
    }
}
```

### Step 3: Create the View

Edit `resources/views/livewire/reports.blade.php`:
```blade
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Reports</h1>
    
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-600">Total Revenue</p>
        <p class="text-3xl font-bold">SGD {{ number_format($totalRevenue, 2) }}</p>
    </div>
</div>
```

### Step 4: Add a Route

Edit `routes/web.php` and add:
```php
use App\Livewire\Reports;

Route::get('/reports', Reports::class)->middleware('auth');
```

Now visit `/reports` in your browser — done!

---

## How to Modify Existing Livewire Components

Let's say you want to add a new field to the customer form.

### Step 1: Find the Component

Livewire components are in `app/Livewire/`. For example:
- `app/Livewire/Customers/Create.php` — Customer creation form
- `resources/views/livewire/customers/create.blade.php` — The HTML

### Step 2: Add Field to Component Logic

Edit the component class (e.g., `app/Livewire/Customers/Create.php`):
```php
public $name;
public $email;
public $website; // NEW FIELD

protected $rules = [
    'name' => 'required|string',
    'email' => 'required|email',
    'website' => 'nullable|url', // NEW VALIDATION
];

public function save()
{
    $this->validate();
    
    Customer::create([
        'name' => $this->name,
        'email' => $this->email,
        'website' => $this->website, // SAVE NEW FIELD
    ]);
    
    return redirect()->to('/customers');
}
```

### Step 3: Add Input to View

Edit the Blade template (e.g., `resources/views/livewire/customers/create.blade.php`):
```blade
<div>
    <label>Website</label>
    <input type="url" wire:model="website" class="border rounded px-3 py-2 w-full">
    @error('website') <span class="text-red-500">{{ $message }}</span> @enderror
</div>
```

### Step 4: Update Database (see next section)

---

## How to Change Company Branding

### Change Company Name

Edit `.env` file:
```env
APP_NAME="Your Company Name"
```

Then in views, use: `{{ config('app.name') }}`

### Change Colors

Edit `resources/css/app.css` and modify Tailwind theme:
```css
@theme {
    --color-primary: #2563eb; /* Change to your brand color */
}
```

Then rebuild CSS:
```bash
npm run build
```

### Add Logo

1. Place your logo in `public/images/logo.png`
2. In your layout file (`resources/views/layouts/app.blade.php`):
```blade
<img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
```

---

## How to Add a New Database Field

Let's add a `tax_id` field to the customers table.

### Step 1: Create a Migration

```bash
php artisan make:migration add_tax_id_to_customers_table
```

### Step 2: Edit the Migration

Open `database/migrations/YYYY_MM_DD_HHMMSS_add_tax_id_to_customers_table.php`:
```php
public function up()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->string('tax_id')->nullable()->after('email');
    });
}

public function down()
{
    Schema::table('customers', function (Blueprint $table) {
        $table->dropColumn('tax_id');
    });
}
```

### Step 3: Run the Migration

```bash
php artisan migrate
```

### Step 4: Update the Model

Edit `app/Models/Customer.php` and add `tax_id` to `$fillable`:
```php
protected $fillable = [
    'name',
    'email',
    'tax_id', // ADD THIS
    'phone',
    // ... other fields
];
```

### Step 5: Update Forms

Now you can add `tax_id` inputs to your Livewire components (see "Modify Components" section).

---

## Common php artisan Commands

These are the commands you'll use most often:

### Development Server
```bash
php artisan serve
# Starts server at http://localhost:8000
```

### Database
```bash
php artisan migrate
# Run new database migrations

php artisan migrate:fresh
# Drop all tables and re-run migrations (CAUTION: deletes all data)

php artisan migrate:status
# See which migrations have run

php artisan db:seed
# Run database seeders (populate sample data)
```

### Testing & Debugging
```bash
php artisan tinker
# Interactive PHP console (test code quickly)
# Example: Customer::all() to see all customers

php artisan route:list
# Show all available routes
```

### Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
# Run these if you see old/stale data
```

### Create Files
```bash
php artisan make:livewire ComponentName
# Create a new Livewire component

php artisan make:model ModelName
# Create a new database model

php artisan make:migration create_table_name
# Create a new database migration
```

---

## Tips & Best Practices

1. **Always run migrations** after changing the database schema
2. **Clear cache** if config changes don't take effect
3. **Use `php artisan route:list`** to debug routing issues
4. **Check `.env` file** if app behaves differently after deployment
5. **Run `npm run build`** after changing CSS/JS files
6. **Use `php artisan tinker`** to test queries before adding them to code

---

## Need Help?

- Laravel Docs: https://laravel.com/docs/12.x
- Livewire Docs: https://livewire.laravel.com/docs
- Tailwind CSS Docs: https://tailwindcss.com/docs
- Stack Overflow: Search "Laravel [your problem]"

Remember: Every Laravel developer was a beginner once. Don't be afraid to experiment — you can always reset the database with `php artisan migrate:fresh`.
