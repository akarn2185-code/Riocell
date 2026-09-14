<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'type',
        'buy_price',
        'sell_price',
        'stock',
        'is_active',
        'description',
        'image',
        'image_data',
        'image_mime'
    ];

    protected $casts = [
        'buy_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relasi ke transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi ke orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}