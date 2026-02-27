<?php

use Livewire\Component;
use App\Models\Customer;
use App\Models\Invoice;

new class extends Component
{
    public $customer_id = null;
    public $invoice_number = '';
    public $line_items = [];
    public $subtotal = 0;
    public $gst_amount = 0;
    public $total = 0;
    public $status = 'draft';

    public function mount()
    {
        $this->addLineItem();
    }

    public function addLineItem()
    {
        $this->line_items[] = [
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'amount' => 0
        ];
    }

    public function removeLineItem($index)
    {
        unset($this->line_items[$index]);
        $this->line_items = array_values($this->line_items);
        $this->calculateTotals();
    }

    #[Computed]
    public function customers()
    {
        return Customer::all();
    }

    public function updatedLineItems()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        
        foreach ($this->line_items as &$item) {
            $item['amount'] = $item['quantity'] * $item['unit_price'];
            $this->subtotal += $item['amount'];
        }
        
        // GST calculation - 9% for Singapore
        $this->gst_amount = round($this->subtotal * 0.09, 2);
        $this->total = $this->subtotal + $this->gst_amount;
    }

    public function saveInvoice()
    {
        $this->calculateTotals();
        
        if (!$this->customer_id) {
            $this->addError('customer_id', 'Please select a customer');
            return;
        }

        if (empty($this->line_items) || empty(array_filter($this->line_items, fn($item) => $item['quantity'] > 0))) {
            $this->addError('line_items', 'Please add at least one line item');
            return;
        }

        try {
            $invoice = Invoice::create([
                'customer_id' => $this->customer_id,
                'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad(Invoice::count() + 1, 3, '0', STR_PAD_LEFT),
                'subtotal' => $this->subtotal,
                'gst_amount' => $this->gst_amount,
                'total' => $this->total,
                'status' => $this->status,
            ]);

            // Create line items
            foreach ($this->line_items as $item) {
                if ($item['quantity'] > 0) {
                    $invoice->items()->create([
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'amount' => $item['amount'],
                    ]);
                }
            }

            session()->flash('success', 'Invoice created successfully!');
            return $this->redirect(route('invoices.index'), navigate: true);
        } catch (\Exception $e) {
            $this->addError('general', 'Error creating invoice: ' . $e->getMessage());
        }
    }
};
?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6">Create Invoice</h2>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form wire:submit="saveInvoice" class="space-y-6">
                    <!-- Customer Selection -->
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Customer
                        </label>
                        <select 
                            id="customer_id"
                            wire:model="customer_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Select a customer</option>
                            @foreach ($this->customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Line Items -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Line Items</h3>
                        <div class="space-y-4">
                            @foreach ($line_items as $index => $item)
                                <div class="border border-gray-200 p-4 rounded-lg">
                                    <div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Description
                                            </label>
                                            <input 
                                                type="text" 
                                                wire:model.lazy="line_items.{{ $index }}.description"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                placeholder="e.g., Web Development"
                                            />
                                        </div>
                                        <div class="col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Quantity
                                            </label>
                                            <input 
                                                type="number" 
                                                wire:model.lazy="line_items.{{ $index }}.quantity"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                min="0"
                                                step="0.01"
                                            />
                                        </div>
                                        <div class="col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Unit Price
                                            </label>
                                            <input 
                                                type="number" 
                                                wire:model.lazy="line_items.{{ $index }}.unit_price"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                                                min="0"
                                                step="0.01"
                                            />
                                        </div>
                                        <div class="col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Amount
                                            </label>
                                            <div class="px-3 py-2 bg-gray-100 rounded-lg text-sm font-semibold">
                                                $ {{ number_format($item['amount'], 2) }}
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex items-end">
                                            @if (count($line_items) > 1)
                                                <button 
                                                    type="button" 
                                                    wire:click="removeLineItem({{ $index }})"
                                                    class="w-full px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                                >
                                                    Remove
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button 
                            type="button" 
                            wire:click="addLineItem"
                            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                        >
                            Add Line Item
                        </button>
                    </div>

                    <!-- Calculations -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="space-y-3">
                            <div class="flex justify-between text-base">
                                <span class="font-medium">Subtotal:</span>
                                <span class="font-semibold">$ {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-base border-t border-gray-200 pt-3">
                                <span class="font-medium">GST (9%):</span>
                                <span class="font-semibold">$ {{ number_format($gst_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-lg border-t border-gray-200 pt-3">
                                <span class="font-bold">Total:</span>
                                <span class="font-bold text-blue-600">$ {{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select 
                            id="status"
                            wire:model="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="draft">Draft</option>
                            <option value="sent">Sent</option>
                            <option value="paid">Paid</option>
                        </select>
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