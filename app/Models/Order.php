<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'customer_phone',
        'quantity',
        'total_price',
        'status',
        'notes',
        'reject_reason'
    ];

    protected $casts = [
        'total_price' => 'decimal:2'
    ];

    // Relasi ke user (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke transaction
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}