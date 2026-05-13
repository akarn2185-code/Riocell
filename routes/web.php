<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\PublicProductController;
use App\Http\Controllers\Pelanggan\HomeController as PelangganHomeController;
use App\Http\Controllers\Pelanggan\CatalogController;
use App\Http\Controllers\Pelanggan\OrderController as PelangganOrderController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\Owner\ProductController;
use App\Http\Controllers\Owner\OrderController as OwnerOrderController;
use App\Http\Controllers\Owner\TransactionController;
use App\Http\Controllers\Owner\ReportController;
use App\Http\Controllers\Owner\ChatLogController;
use App\Http\Controllers\Owner\TukarSaldoController;
use App\Http\Controllers\Owner\SaldoIndukController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==================== PUBLIC ROUTES (TANPA LOGIN) ====================
// Produk publik - bisa dilihat tanpa login
Route::get('/produk', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product}', [PublicProductController::class, 'show'])->name('products.show');

// Dashboard Redirect
Route::get('/dashboard', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'owner' 
            ? redirect()->route('owner.dashboard') 
            : redirect()->route('pelanggan.home');
    }
    return redirect()->route('login');
})->middleware('auth')->name('dashboard');

// ==================== CHATBOT API ====================
Route::middleware('auth')->prefix('api/chat')->group(function () {
    Route::post('/send', [ChatbotController::class, 'sendMessage'])->name('chat.send');
    Route::get('/history', [ChatbotController::class, 'getHistory'])->name('chat.history');
});

// ==================== ROUTE PELANGGAN ====================
Route::middleware(['auth', 'verified', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/home', [PelangganHomeController::class, 'index'])->name('home');
    Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');
    Route::get('/katalog/{product}', [CatalogController::class, 'show'])->name('catalog.show');
    Route::get('/pesanan', [PelangganOrderController::class, 'index'])->name('orders');
    Route::get('/pesan/{product}', [PelangganOrderController::class, 'create'])->name('order.create');
    Route::post('/pesan', [PelangganOrderController::class, 'store'])->name('order.store');
    
    // ROUTE CHAT FULL SCREEN UNTUK PELANGGAN
    Route::get('/chat', function() {
        return view('pelanggan.chat');
    })->name('chat');

    Route::get('/pembayaran/{order}', [PelangganOrderController::class, 'payment'])->name('order.payment');
    
    // ROUTE CETAK STRUK
    Route::get('/pesanan/{order}/struk', [PelangganOrderController::class, 'receipt'])->name('order.receipt');
});

// ==================== ROUTE OWNER ====================
Route::middleware(['auth', 'verified', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Produk
    Route::resource('products', ProductController::class);
    
    // Transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    
    // Struk Transaksi
    Route::get('/transactions/{transaction}/struk/preview', [App\Http\Controllers\Owner\StrukController::class, 'preview'])->name('transactions.struk.preview');
    Route::get('/transactions/{transaction}/struk/download', [App\Http\Controllers\Owner\StrukController::class, 'download'])->name('transactions.struk.download');
    Route::get('/transactions/{transaction}/struk/print', [App\Http\Controllers\Owner\StrukController::class, 'print'])->name('transactions.struk.print');
    
    // Pesanan Online
    Route::get('/orders', [OwnerOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/process', [OwnerOrderController::class, 'process'])->name('orders.process');
    Route::patch('/orders/{order}/complete', [OwnerOrderController::class, 'complete'])->name('orders.complete');
    Route::patch('/orders/{order}/reject', [OwnerOrderController::class, 'reject'])->name('orders.reject');
    
    // Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
    Route::get('/reports/download', [ReportController::class, 'download'])->name('reports.download');

        // Chat Logs
    Route::get('/chatlogs', [ChatLogController::class, 'index'])->name('chatlogs.index');
    Route::get('/chatlogs/{sessionId}', [ChatLogController::class, 'show'])->name('chatlogs.show');
    Route::delete('/chatlogs/{sessionId}', [ChatLogController::class, 'destroy'])->name('chatlogs.destroy');
    
    // Tukar Saldo
    Route::get('/tukar-saldo', [TukarSaldoController::class, 'index'])->name('tukar-saldo.index');
    Route::post('/tukar-saldo/calculate', [TukarSaldoController::class, 'calculate'])->name('tukar-saldo.calculate');
    Route::post('/tukar-saldo', [TukarSaldoController::class, 'store'])->name('tukar-saldo.store');
    
    // Saldo Induk
    Route::get('/saldo-induk', [SaldoIndukController::class, 'index'])->name('saldo-induk.index');
    Route::post('/saldo-induk/deposit', [SaldoIndukController::class, 'deposit'])->name('saldo-induk.deposit');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';