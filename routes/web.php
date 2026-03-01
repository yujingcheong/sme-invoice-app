<?php

use Illuminate\Support\Facades\Route;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quotation;

// Note: /health endpoint is defined in bootstrap/app.php (outside web middleware)
// This ensures health checks work without sessions, cookies, or encryption

// Portfolio page (public - no auth required)
Route::view('/portfolio', 'portfolio')->name('portfolio');

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $totalInvoices = Invoice::count();
        $totalRevenue = Invoice::sum('total') ?? 0;
        $totalQuotations = Quotation::count();
        $acceptedQuotations = Quotation::where('status', 'accepted')->count();
        $conversionRate = $totalQuotations > 0
            ? round(($acceptedQuotations / $totalQuotations) * 100, 1)
            : 0;
        $recentInvoices = Invoice::with('customer')->latest()->take(5)->get();
        $recentCustomers = Customer::withCount('invoices', 'quotations')->latest()->take(5)->get();

        return view('components.⚡dashboard', compact(
            'totalInvoices', 'totalRevenue', 'totalQuotations',
            'conversionRate', 'recentInvoices', 'recentCustomers'
        ));
    })->name('dashboard');
    
    // Customer routes
    Route::get('customers', function () {
        $customers = \App\Models\Customer::latest()->get();
        return view('components.customers.⚡index', ['customers' => $customers]);
    })->name('customers.index');
    
    Route::get('customers/create', function () {
        $customer = null;
        return view('components.customers.⚡form', ['customer' => $customer]);
    })->name('customers.create');
    
    Route::get('customers/{customer}', function (\App\Models\Customer $customer) {
        return view('components.customers.⚡show', ['customer' => $customer]);
    })->name('customers.show');
    
    Route::get('customers/{customer}/edit', function (\App\Models\Customer $customer) {
        return view('components.customers.⚡form', ['customer' => $customer]);
    })->name('customers.edit');
    
    // Invoice routes
    Route::get('invoices', function () {
        return view('components.invoices.⚡index');
    })->name('invoices.index');
    
    Route::get('invoices/create', function () {
        return view('components.invoices.⚡create');
    })->name('invoices.create');
});

require __DIR__.'/settings.php';
