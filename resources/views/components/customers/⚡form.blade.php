<x-layouts::app :title="$customer ? __('Edit Customer') : __('Add Customer')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                {{ $customer ? 'Edit Customer' : 'Add Customer' }}
            </h1>
            <a href="{{ route('customers.index') }}" 
               class="text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">
                &larr; Back to Customers
            </a>
        </div>

        <!-- Form -->
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
            <form action="{{ $customer ? route('customers.update', $customer) : route('customers.store') }}" method="POST" class="space-y-6">
                @csrf
                @if($customer)
                    @method('PUT')
                @endif

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name"
                        name="name"
                        value="{{ old('name', $customer->name ?? '') }}"
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="John Doe"
                        required
                    />
                    @error('name') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email"
                        name="email"
                        value="{{ old('email', $customer->email ?? '') }}"
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="john@example.com"
                        required
                    />
                    @error('email') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Phone
                    </label>
                    <input 
                        type="text" 
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $customer->phone ?? '') }}"
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="+65 1234 5678"
                    />
                    @error('phone') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Company Name
                    </label>
                    <input 
                        type="text" 
                        id="company_name"
                        name="company_name"
                        value="{{ old('company_name', $customer->company_name ?? '') }}"
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Acme Corporation"
                    />
                    @error('company_name') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Address
                    </label>
                    <textarea 
                        id="address"
                        name="address"
                        rows="3"
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="123 Main Street, Singapore 123456"
                    >{{ old('address', $customer->address ?? '') }}</textarea>
                    @error('address') 
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('customers.index') }}" 
                       class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-neutral-100">
                        Cancel
                    </a>
                    <button 
                        type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                        {{ $customer ? 'Update Customer' : 'Create Customer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>