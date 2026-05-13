<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\SaldoInduk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('product');

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('transaction_type', $request->type);
        }

        $transactions = $query->latest()->get();

        // Statistik
        $todayStats = Transaction::whereDate('created_at', Carbon::today())->get();
        $totalOmzet = $todayStats->sum('sell_price');
        $totalProfit = $todayStats->sum('profit');

        return view('owner.transactions.index', compact('transactions', 'totalOmzet', 'totalProfit'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('owner.transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_phone' => 'required|string|min:10|max:15',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek stok untuk produk fisik
        if ($product->type === 'fisik' && $product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!')->withInput();
        }

        $buyPrice = $product->buy_price * $request->quantity;
        $sellPrice = $product->sell_price * $request->quantity;
        $profit = $sellPrice - $buyPrice;

        // Simpan transaksi
        Transaction::create([
            'product_id' => $request->product_id,
            'customer_phone' => $request->customer_phone,
            'quantity' => $request->quantity,
            'buy_price' => $buyPrice,
            'sell_price' => $sellPrice,
            'profit' => $profit,
            'transaction_type' => 'pos',
            'notes' => $request->notes
        ]);

        // Kurangi stok jika produk fisik
        if ($product->type === 'fisik') {
            $product->decrement('stock', $request->quantity);
        }

        // Kurangi saldo induk jika produk digital
        if ($product->type === 'digital') {
            $saldoInduk = SaldoInduk::first();
            if ($saldoInduk) {
                $saldoInduk->decrement('balance', $buyPrice);
            }
        }

        $transactionId = Transaction::latest()->first()->id;
        return redirect()->route('owner.transactions.index')
        ->with('success', 'Transaksi berhasil dicatat!')
        ->with('print_struk', $transactionId);
    }
}