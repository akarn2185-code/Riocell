<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::where('user_id', Auth::id())->with('product');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        $statusCounts = [
            'pending' => Order::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'diproses' => Order::where('user_id', Auth::id())->where('status', 'diproses')->count(),
            'selesai' => Order::where('user_id', Auth::id())->where('status', 'selesai')->count(),
            'ditolak' => Order::where('user_id', Auth::id())->where('status', 'ditolak')->count(),
        ];

        return view('pelanggan.orders', compact('orders', 'statusCounts'));
    }

    public function create(Product $product)
    {
        return view('pelanggan.order-create', compact('product'));
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

        if ($product->type === 'fisik' && $product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $totalPrice = $product->sell_price * $request->quantity;

        // Simpan pesanan
        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'customer_phone' => $request->customer_phone,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes
        ]);

        // Arahkan ke halaman pembayaran!
        return redirect()->route('pelanggan.order.payment', $order->id);
    }

    // FUNGSI BARU: Halaman Pembayaran
    public function payment(Order $order)
    {
        // Pastikan pesanan milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pelanggan.payment', compact('order'));
    }

    // FUNGSI BARU: Cetak Struk
    public function receipt(Order $order)
    {
        // Keamanan: Memastikan hanya pemilik pesanan yang bisa melihat struknya
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('pelanggan.receipt', compact('order'));
    }
}