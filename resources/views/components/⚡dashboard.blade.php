<?php

use Livewire\Component;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quotation;

new class extends Component
{
    public function with(): array
    {
        $totalInvoices = Invoice::count();
        $totalRevenue = Invoice::sum('total') ?? 0;
        
        $totalQuotations = Quotation::count();
        $acceptedQuotations = Quotation::where('status', 'accepted')->count();
        $conversionRate = $totalQuotations > 0 
            ? round(($acceptedQuotations / $totalQuotations) * 100, 1) 
            : 0;
        
        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->take(5)
            ->get();
        
        $recentCustomers = Customer::withCount('invoices', 'quotations')
            ->latest()
            ->take(5)
            ->get();
        
        return [
            'totalInvoices' => $totalInvoices,
            'totalRevenue' => $totalRevenue,
            'totalQuotations' => $totalQuotations,
            'conversionRate' => $conversionRate,
            'recentInvoices' => $recentInvoices,
            'recentCustomers' => $recentCustomers,
        ];
    }
};
?>

<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Stats Grid -->
        <div class="grid gap-4 md:grid-cols-4">
            <!-- Total Invoices -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Invoices</div>
                <div class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalInvoices }}</div>
            </div>
            
            <!-- Total Revenue -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Revenue</div>
                <div class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">$ {{ number_format($totalRevenue, 2, '.', ',') }}</div>
            </div>
            
            <!-- Total Quotations -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Quotations</div>
                <div class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalQuotations }}</div>
            </div>
            
            <!-- Conversion Rate -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Conversion Rate</div>
                <div class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $conversionRate }}%</div>
            </div>
        </div>

        <!-- Recent Items Grid -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Recent Invoices -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">Recent Invoices</h2>
                
                @if($recentInvoices->isEmpty())
                    <div class="text-center py-8 text-neutral-500 dark:text-neutral-400">
                        No invoices yet. Create your first invoice to get started.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentInvoices as $invoice)
                            <div class="flex items-center justify-between py-2 border-b border-neutral-100 dark:border-neutral-700 last:border-0">
                                <div>
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">{{ $invoice->invoice_number }}</div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $invoice->customer->name ?? 'N/A' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">$ {{ number_format($invoice->total, 2, '.', ',') }}</div>
                                    <div class="text-sm">
                                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium
                                            @if($invoice->status === 'paid') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($invoice->status === 'sent') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                            @else bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400
                                            @endif">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recent Customers -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">Recent Customers</h2>
                
                @if($recentCustomers->isEmpty())
                    <div class="text-center py-8 text-neutral-500 dark:text-neutral-400">
                        No customers yet. Add your first customer to get started.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentCustomers as $customer)
                            <div class="flex items-center justify-between py-2 border-b border-neutral-100 dark:border-neutral-700 last:border-0">
                                <div>
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">{{ $customer->name }}</div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $customer->email }}</div>
                                </div>
                                <div class="text-right text-sm text-neutral-500 dark:text-neutral-400">
                                    <div>{{ $customer->invoices_count }} invoices</div>
                                    <div>{{ $customer->quotations_count }} quotes</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts::app>