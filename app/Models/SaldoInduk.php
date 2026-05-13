<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoInduk extends Model
{
    protected $table = 'saldo_induk';
    
    protected $fillable = [
        'balance',
        'last_deposit',
        'last_deposit_at'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'last_deposit' => 'decimal:2',
        'last_deposit_at' => 'datetime'
    ];
}