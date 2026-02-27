<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'customer_id',
        'quotation_number',
        'status',
        'subtotal',
        'gst_amount',
        'total',
        'valid_until',
        'notes',
    ];

    protected $casts = [
        'valid_until' => 'date',
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
        return $this->hasMany(QuotationItem::class);
    }
}
