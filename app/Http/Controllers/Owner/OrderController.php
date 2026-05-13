<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\SaldoInduk;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'product']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        $statusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'diproses' => Order::where('status', 'diproses')->count(),
            'selesai' => Order::where('status', 'selesai')->count(),
            'ditolak' => Order::where('status', 'ditolak')->count(),
        ];

        return view('owner.orders.index', compact('orders', 'statusCounts'));
    }

    public function process(Order $order)
    {
        $order->update(['status' => 'diproses']);
        return back()->with('success', 'Pesanan sedang diproses!');
    }

    public function complete(Order $order)
    {
        // Update status pesanan
        $order->update(['status' => 'selesai']);

        // Buat transaksi dari pesanan
        $product = $order->product;
        $profit = ($product->sell_price - $product->buy_price) * $order->quantity;

        Transaction::create([
            'product_id' => $order->product_id,
            'order_id' => $order->id,
            'customer_phone' => $order->customer_phone,
            'quantity' => $order->quantity,
            'buy_price' => $product->buy_price * $order->quantity,
            'sell_price' => $product->sell_price * $order->quantity,
            'profit' => $profit,
            'transaction_type' => 'online',
            'notes' => 'Pesanan online #' . $order->id
        ]);

        // Kurangi stok jika produk fisik
        if ($product->type === 'fisik') {
            $product->decrement('stock', $order->quantity);
        }

        // Kurangi saldo induk jika produk digital
        if ($product->type === 'digital') {
            $saldoInduk = SaldoInduk::first();
            if ($saldoInduk) {
                $saldoInduk->decrement('balance', $product->buy_price * $order->quantity);
            }
        }

        return back()->with('success', 'Pesanan telah diselesaikan dan transaksi tercatat!');
    }

    public function reject(Request $request, Order $order)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:500'
        ]);

        $order->update([
            'status' => 'ditolak',
            'reject_reason' => $request->reject_reason
        ]);

        return back()->with('success', 'Pesanan ditolak!');
    }
}