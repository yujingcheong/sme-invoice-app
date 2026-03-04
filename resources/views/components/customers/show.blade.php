<x-layouts::app :title="__('Customer Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('customers.index') }}" 
                       class="text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">
                        Customers
                    </a>
                    <span class="text-neutral-400">/</span>
                    <span class="text-neutral-900 dark:text-neutral-100">{{ $customer->name }}</span>
                </div>
                <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                    {{ $customer->name }}
                </h1>
            </div>
            <a href="{{ route('customers.edit', $customer) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Customer
            </a>
        </div>

        <!-- Customer Info -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">Customer Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400 mb-1">Email</div>
                    <div class="text-neutral-900 dark:text-neutral-100">{{ $customer->email }}</div>
                </div>
                
                <div>
                    <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400 mb-1">Phone</div>
                    <div class="text-neutral-900 dark:text-neutral-100">{{ $customer->phone ?? '-' }}</div>
                </div>
                
                <div>
                    <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400 mb-1">Company</div>
                    <div class="text-neutral-900 dark:text-neutral-100">{{ $customer->company_name ?? '-' }}</div>
                </div>
                
                <div>
                    <div class="text-sm font-medium text-neutral-500 dark:text-neutral-400 mb-1">Address</div>
                    <div class="text-neutral-900 dark:text-neutral-100">{{ $customer->address ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Invoices & Quotations -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Invoices -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">
                    Invoices ({{ $customer->invoices->count() }})
                </h2>
                
                @if($customer->invoices->isEmpty())
                    <div class="text-center py-8 text-neutral-500 dark:text-neutral-400">
                        No invoices yet.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($customer->invoices as $invoice)
                            <div class="flex items-center justify-between py-3 border-b border-neutral-100 dark:border-neutral-700 last:border-0">
                                <div>
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">
                                        {{ $invoice->invoice_number }}
                                    </div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                        Due: {{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">
                                        $ {{ number_format($invoice->total, 2, '.', ',') }}
                                    </div>
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

            <!-- Quotations -->
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-4">
                    Quotations ({{ $customer->quotations->count() }})
                </h2>
                
                @if($customer->quotations->isEmpty())
                    <div class="text-center py-8 text-neutral-500 dark:text-neutral-400">
                        No quotations yet.
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($customer->quotations as $quotation)
                            <div class="flex items-center justify-between py-3 border-b border-neutral-100 dark:border-neutral-700 last:border-0">
                                <div>
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">
                                        {{ $quotation->quotation_number }}
                                    </div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                        Valid until: {{ $quotation->valid_until?->format('M d, Y') ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-neutral-900 dark:text-neutral-100">
                                        $ {{ number_format($quotation->total, 2, '.', ',') }}
                                    </div>
                                    <div class="text-sm">
                                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium
                                            @if($quotation->status === 'accepted') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($quotation->status === 'sent') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                            @elseif($quotation->status === 'rejected') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                            @else bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400
                                            @endif">
                                            {{ ucfirst($quotation->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts::app>