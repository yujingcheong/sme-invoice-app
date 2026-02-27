<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Health check endpoint (no auth required)
Route::get('/health', function () {
    try {
        // Test database connection
        DB::connection()->getPdo();
        
        return response()->json([
            'status' => 'ok',
            'database' => 'connected',
            'timestamp' => now()->toIso8601String(),
            'environment' => app()->environment(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'database' => 'disconnected',
            'error' => $e->getMessage(),
            'timestamp' => now()->toIso8601String(),
        ], 500);
    }
})->name('health');

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('components.⚡dashboard');
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
