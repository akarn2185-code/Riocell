<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\SaldoInduk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Statistik hari ini
        $todayTransactions = Transaction::whereDate('created_at', $today)->get();
        $todayOmzet = $todayTransactions->sum('sell_price');
        $todayProfit = $todayTransactions->sum('profit');
        $todayCount = $todayTransactions->count();

        // Pesanan pending
        $pendingOrders = Order::where('status', 'pending')->count();

        // Saldo induk
        $saldoInduk = SaldoInduk::first();
        $saldo = $saldoInduk ? $saldoInduk->balance : 0;

        // Pesanan terbaru (5 terakhir)
        $recentOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();

        // Transaksi terbaru (5 terakhir)
        $recentTransactions = Transaction::with('product')
            ->latest()
            ->take(5)
            ->get();

        // Statistik bulanan
        $monthlyTransactions = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get();
        $monthlyOmzet = $monthlyTransactions->sum('sell_price');
        $monthlyProfit = $monthlyTransactions->sum('profit');

        // CEK STOK MENIPIS (Stok <= 5 khusus untuk produk fisik)
        $lowStockProducts = Product::where('type', 'fisik')
                                   ->where('stock', '<=', 5)
                                   ->get();

        return view('owner.dashboard', compact(
            'todayOmzet',
            'todayProfit',
            'todayCount',
            'pendingOrders',
            'saldo',
            'recentOrders',
            'recentTransactions',
            'monthlyOmzet',
            'monthlyProfit',
            'lowStockProducts' // Kirim data peringatan ke view
        ));
    }
}