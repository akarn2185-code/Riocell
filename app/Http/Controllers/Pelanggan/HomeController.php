<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        
        $latestProducts = Product::where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        // Hitung pesanan user
        $pendingOrders = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        $completedOrders = Order::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->count();

        
        return view('pelanggan.home', compact('latestProducts', 'pendingOrders', 'completedOrders'));
    }
}