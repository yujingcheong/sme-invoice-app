<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quotation;

// Note: /health endpoint is defined in bootstrap/app.php (outside web middleware)
// This ensures health checks work without sessions, cookies, or encryption

// Portfolio page (public - no auth required)
Route::view('/portfolio', 'portfolio')->name('portfolio');

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
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
    
    // ── Customer Routes ──────────────────────────────────────────────
    Route::get('customers', function () {
        $customers = Customer::withCount('invoices', 'quotations')->latest()->get();
        return view('components.customers.⚡index', ['customers' => $customers]);
    })->name('customers.index');
    
    Route::get('customers/create', function () {
        $customer = null;
        return view('components.customers.⚡form', ['customer' => $customer]);
    })->name('customers.create');
    
    Route::post('customers', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);
        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    })->name('customers.store');
    
    Route::get('customers/{customer}', function (Customer $customer) {
        $customer->load(['invoices', 'quotations']);
        return view('components.customers.⚡show', ['customer' => $customer]);
    })->name('customers.show');
    
    Route::get('customers/{customer}/edit', function (Customer $customer) {
        return view('components.customers.⚡form', ['customer' => $customer]);
    })->name('customers.edit');
    
    Route::put('customers/{customer}', function (Request $request, Customer $customer) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);
        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    })->name('customers.update');
    
    Route::delete('customers/{customer}', function (Customer $customer) {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    })->name('customers.destroy');
    
    // ── Invoice Routes ───────────────────────────────────────────────
    Route::get('invoices', function () {
        $invoices = Invoice::with('customer')->latest()->get();
        return view('components.invoices.⚡index', ['invoices' => $invoices]);
    })->name('invoices.index');
    
    Route::get('invoices/create', function () {
        $customers = Customer::orderBy('name')->get();
        return view('components.invoices.⚡create', ['customers' => $customers]);
    })->name('invoices.create');
    
    Route::post('invoices', function (Request $request) {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:draft,sent,paid',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        $lineItems = [];
        foreach ($request->items as $item) {
            $amount = round($item['quantity'] * $item['unit_price'], 2);
            $subtotal += $amount;
            $lineItems[] = [
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'amount' => $amount,
            ];
        }

        $gstAmount = round($subtotal * 0.09, 2);
        $total = $subtotal + $gstAmount;

        $invoice = Invoice::create([
            'customer_id' => $request->customer_id,
            'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad(Invoice::count() + 1, 3, '0', STR_PAD_LEFT),
            'subtotal' => $subtotal,
            'gst_amount' => $gstAmount,
            'total' => $total,
            'status' => $request->status,
        ]);

        foreach ($lineItems as $item) {
            $invoice->items()->create($item);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully!');
    })->name('invoices.store');

    // ── Quotation Routes ─────────────────────────────────────────────
    Route::get('quotations', function () {
        $quotations = Quotation::with('customer')->latest()->get();
        return view('components.quotations.index', ['quotations' => $quotations]);
    })->name('quotations.index');
});

require __DIR__.'/settings.php';
