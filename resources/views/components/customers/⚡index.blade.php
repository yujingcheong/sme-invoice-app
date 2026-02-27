<?php

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Customer;

new class extends Component
{
    #[Url]
    public string $search = '';
    
    public function with(): array
    {
        $customers = Customer::query()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('company_name', 'like', '%' . $this->search . '%');
                });
            })
            ->withCount('invoices', 'quotations')
            ->latest()
            ->get();
        
        return ['customers' => $customers];
    }
    
    public function delete($customerId): void
    {
        $customer = Customer::findOrFail($customerId);
        $customer->delete();
    }
};
?>

<x-layouts::app :title="__('Customers')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">Customers</h1>
            <a href="{{ route('customers.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Customer
            </a>
        </div>

        <!-- Search -->
        <div class="relative">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search"
                placeholder="Search customers by name, email, or company..."
                class="w-full px-4 py-2 pl-10 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <!-- Customers List -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 overflow-hidden">
            @if($customers->isEmpty())
                <div class="text-center py-12 px-4">
                    @if($search)
                        <div class="text-neutral-500 dark:text-neutral-400">
                            No customers found matching "{{ $search }}"
                        </div>
                    @else
                        <div class="text-neutral-500 dark:text-neutral-400 mb-4">
                            No customers yet. Add your first customer to get started.
                        </div>
                        <a href="{{ route('customers.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                            Add Your First Customer
                        </a>
                    @endif
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead class="bg-neutral-50 dark:bg-neutral-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Invoices</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Quotations</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                            @foreach($customers as $customer)
                                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-900/30">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('customers.show', $customer) }}" class="font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                            {{ $customer->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ $customer->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ $customer->company_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ $customer->invoices_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ $customer->quotations_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('customers.edit', $customer) }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                            Edit
                                        </a>
                                        <button 
                                            wire:click="delete({{ $customer->id }})"
                                            wire:confirm="Are you sure you want to delete this customer?"
                                            class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>