<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'product_id',
        'order_id',
        'customer_phone',
        'quantity',
        'buy_price',
        'sell_price',
        'profit',
        'transaction_type',
        'notes'
    ];

    protected $casts = [
        'buy_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'profit' => 'decimal:2'
    ];

    // Relasi ke product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}