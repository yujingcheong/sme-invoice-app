<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'status',
        'subtotal',
        'gst_amount',
        'total',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
