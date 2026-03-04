<x-layouts::app :title="__('Invoices')">
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-neutral-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Invoices</h2>
                    <a 
                        href="{{ route('invoices.create') }}" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-semibold"
                    >
                        Create Invoice
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="text-xs uppercase bg-gray-100 dark:bg-neutral-700 border-b">
                            <tr>
                                <th class="px-6 py-3">Invoice #</th>
                                <th class="px-6 py-3">Customer</th>
                                <th class="px-6 py-3">Subtotal</th>
                                <th class="px-6 py-3">GST</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-semibold">{{ $invoice->invoice_number }}</td>
                                    <td class="px-6 py-4">{{ $invoice->customer->name }}</td>
                                    <td class="px-6 py-4">$ {{ number_format($invoice->subtotal, 2) }}</td>
                                    <td class="px-6 py-4">$ {{ number_format($invoice->gst_amount, 2) }}</td>
                                    <td class="px-6 py-4 font-semibold">$ {{ number_format($invoice->total, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $invoice->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $invoice->status === 'sent' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                        ">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="#" class="text-blue-500 hover:underline">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        No invoices found. <a href="{{ route('invoices.create') }}" class="text-blue-500 hover:underline">Create one</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts::app>