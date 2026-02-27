<?php

use Illuminate\Support\Facades\Route;

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
});

require __DIR__.'/settings.php';
