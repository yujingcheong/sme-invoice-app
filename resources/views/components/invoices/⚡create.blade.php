<x-layouts::app :title="__('Create Invoice')">
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-neutral-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold">Create Invoice</h2>
                    <a href="{{ route('invoices.index') }}" class="text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">
                        &larr; Back to Invoices
                    </a>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('invoices.store') }}" method="POST" class="space-y-6" id="invoice-form">
                    @csrf

                    <!-- Customer Selection -->
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">
                            Customer <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="customer_id"
                            name="customer_id"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                            <option value="">Select a customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} {{ $customer->company_name ? '(' . $customer->company_name . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">
                            Status
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="sent" {{ old('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="paid" {{ old('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <!-- Line Items -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Line Items</h3>
                        <div id="line-items-container" class="space-y-4">
                            <!-- Line item template rendered by JS -->
                        </div>
                        <button
                            type="button"
                            onclick="addLineItem()"
                            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                        >
                            + Add Line Item
                        </button>
                    </div>

                    <!-- Calculations -->
                    <div class="bg-gray-50 dark:bg-neutral-900 p-6 rounded-lg">
                        <div class="space-y-3">
                            <div class="flex justify-between text-base">
                                <span class="font-medium">Subtotal:</span>
                                <span class="font-semibold" id="display-subtotal">$ 0.00</span>
                            </div>
                            <div class="flex justify-between text-base border-t border-gray-200 dark:border-neutral-700 pt-3">
                                <span class="font-medium">GST (9%):</span>
                                <span class="font-semibold" id="display-gst">$ 0.00</span>
                            </div>
                            <div class="flex justify-between text-lg border-t border-gray-200 dark:border-neutral-700 pt-3">
                                <span class="font-bold">Total:</span>
                                <span class="font-bold text-blue-600" id="display-total">$ 0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button
                            type="submit"
                            class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 font-semibold"
                        >
                            Create Invoice
                        </button>
                        <a
                            href="{{ route('invoices.index') }}"
                            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 font-semibold"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let lineItemIndex = 0;

    function addLineItem() {
        const container = document.getElementById('line-items-container');
        const idx = lineItemIndex++;
        const div = document.createElement('div');
        div.className = 'border border-gray-200 dark:border-neutral-700 p-4 rounded-lg';
        div.id = 'line-item-' + idx;
        div.innerHTML = `
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-5 sm:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Description</label>
                    <input type="text" name="items[${idx}][description]"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100"
                           placeholder="e.g., Web Development" required />
                </div>
                <div class="col-span-3 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Quantity</label>
                    <input type="number" name="items[${idx}][quantity]"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 line-qty"
                           min="0.01" step="0.01" value="1" data-idx="${idx}" oninput="recalc()" required />
                </div>
                <div class="col-span-3 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Unit Price ($)</label>
                    <input type="number" name="items[${idx}][unit_price]"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 line-price"
                           min="0" step="0.01" value="0" data-idx="${idx}" oninput="recalc()" required />
                </div>
                <div class="col-span-3 sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-1">Amount</label>
                    <div class="px-3 py-2 bg-gray-100 dark:bg-neutral-700 rounded-lg text-sm font-semibold" id="line-amount-${idx}">$ 0.00</div>
                </div>
                <div class="col-span-2 flex items-end">
                    <button type="button" onclick="removeLineItem(${idx})"
                            class="w-full px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">
                        Remove
                    </button>
                </div>
            </div>
        `;
        container.appendChild(div);
        recalc();
    }

    function removeLineItem(idx) {
        const el = document.getElementById('line-item-' + idx);
        if (el) el.remove();
        // Don't allow removing the last item
        if (document.querySelectorAll('#line-items-container > div').length === 0) {
            addLineItem();
        }
        recalc();
    }

    function recalc() {
        let subtotal = 0;
        const items = document.querySelectorAll('#line-items-container > div');
        items.forEach(function(item) {
            const qty = parseFloat(item.querySelector('.line-qty')?.value) || 0;
            const price = parseFloat(item.querySelector('.line-price')?.value) || 0;
            const amount = qty * price;
            subtotal += amount;
            const idx = item.querySelector('.line-qty')?.dataset.idx;
            if (idx !== undefined) {
                const amtEl = document.getElementById('line-amount-' + idx);
                if (amtEl) amtEl.textContent = '$ ' + amount.toFixed(2);
            }
        });
        const gst = Math.round(subtotal * 0.09 * 100) / 100;
        const total = subtotal + gst;
        document.getElementById('display-subtotal').textContent = '$ ' + subtotal.toFixed(2);
        document.getElementById('display-gst').textContent = '$ ' + gst.toFixed(2);
        document.getElementById('display-total').textContent = '$ ' + total.toFixed(2);
    }

    // Add first line item on page load
    document.addEventListener('DOMContentLoaded', function() {
        addLineItem();
    });
</script>
</x-layouts::app>