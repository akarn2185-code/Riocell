<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TukarSaldoController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('notes', 'like', '%Tukar Saldo%')
            ->latest()
            ->take(20)
            ->get();

        return view('owner.tukar-saldo.index', compact('transactions'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'fee_percentage' => 'required|numeric|min:0|max:100'
        ]);

        $amount = $request->amount;
        $feePercentage = $request->fee_percentage;
        $fee = ($amount * $feePercentage) / 100;
        $customerReceives = $amount - $fee;

        return response()->json([
            'amount' => $amount,
            'fee_percentage' => $feePercentage,
            'fee' => $fee,
            'customer_receives' => $customerReceives
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_phone' => 'required|string|min:10|max:15',
            'ewallet_type' => 'required|string',
            'amount' => 'required|numeric|min:10000',
            'fee_percentage' => 'required|numeric|min:0|max:100'
        ]);

        $amount = $request->amount;
        $feePercentage = $request->fee_percentage;
        $fee = ($amount * $feePercentage) / 100;
        $customerReceives = $amount - $fee;

        Transaction::create([
            'product_id' => null,
            'customer_phone' => $request->customer_phone,
            'quantity' => 1,
            'buy_price' => $customerReceives, // Uang yang diberikan ke pelanggan
            'sell_price' => $amount, // Saldo yang diterima dari pelanggan
            'profit' => $fee,
            'transaction_type' => 'pos',
            'notes' => "Tukar Saldo {$request->ewallet_type} - Rp " . number_format($amount, 0, ',', '.') . " (Fee: {$feePercentage}%)"
        ]);

        return redirect()->route('owner.tukar-saldo.index')->with('success', 'Transaksi Tukar Saldo berhasil dicatat!');
    }
}