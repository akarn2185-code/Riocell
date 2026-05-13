<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Owner') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Greeting -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl sm:rounded-2xl p-4 sm:p-6 mb-6 text-white shadow-md">
                <h3 class="text-xl sm:text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-blue-100 text-sm sm:text-base mt-1">Ringkasan bisnis Anda hari ini</p>
            </div>

            <!-- ALERT STOK MENIPIS -->
            @if($lowStockProducts->count() > 0)
            <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 rounded-r-xl shadow-sm p-4 sm:p-5 mb-6 animate-pulse">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 w-full">
                        <h3 class="text-sm sm:text-base font-bold text-red-800 dark:text-red-200 uppercase tracking-wider">
                            ⚠️ Peringatan: Stok Menipis!
                        </h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            <p class="mb-2">Segera lakukan restock untuk produk fisik berikut:</p>
                            <ul class="list-disc list-inside space-y-1 bg-white/50 dark:bg-black/20 p-3 rounded-lg">
                                @foreach($lowStockProducts as $item)
                                    <li class="flex justify-between items-center">
                                        <span class="font-medium">{{ $item->name }}</span>
                                        <span class="px-2 py-0.5 bg-red-200 dark:bg-red-800 rounded text-xs font-bold">Sisa: {{ $item->stock }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('owner.products.index') }}" class="text-xs font-medium text-red-800 dark:text-red-200 hover:underline flex items-center">
                                Kelola Produk Sekarang →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- END ALERT -->

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6">
                <!-- Omzet Hari Ini -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-green-100 dark:bg-green-900 rounded-full">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Omzet Hari Ini</p>
                            <p class="text-base sm:text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($todayOmzet, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Laba Hari Ini -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Laba Hari Ini</p>
                            <p class="text-base sm:text-2xl font-bold text-green-600">Rp {{ number_format($todayProfit, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pesanan Pending -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Pesanan Pending</p>
                            <p class="text-base sm:text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
                        </div>
                    </div>
                </div>

                <!-- Saldo Induk (Clickable) -->
                <a href="{{ route('owner.saldo-induk.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-lg transition block">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Saldo Induk</p>
                            <p class="text-base sm:text-2xl font-bold text-purple-600">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-3 sm:gap-4 mb-6">
                <a href="{{ route('owner.transactions.create') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 text-center hover:shadow-lg transition group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Transaksi</p>
                </a>

                <a href="{{ route('owner.orders.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 text-center hover:shadow-lg transition group relative">
                    @if($pendingOrders > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center">{{ $pendingOrders }}</span>
                    @endif
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Pesanan</p>
                </a>

                <a href="{{ route('owner.products.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 text-center hover:shadow-lg transition group relative">
                    @if($lowStockProducts->count() > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center">{{ $lowStockProducts->count() }}</span>
                    @endif
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Produk</p>
                </a>

                <a href="{{ route('owner.tukar-saldo.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 text-center hover:shadow-lg transition group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-emerald-500 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Tukar Saldo</p>
                </a>

                <a href="{{ route('owner.reports.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 text-center hover:shadow-lg transition group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-red-500 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Laporan</p>
                </a>

                <a href="{{ route('owner.chatlogs.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 text-center hover:shadow-lg transition group">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-indigo-500 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <p class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">Chat AI</p>
                </a>
            </div>

            <!-- Recent Orders & Transactions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Orders -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Pesanan Terbaru</h3>
                            <a href="{{ route('owner.orders.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentOrders as $order)
                        <div class="p-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->product->name ?? 'Produk' }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->customer_phone }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($order->status == 'diproses') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($order->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        @empty
                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p>Belum ada pesanan</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Transaksi Terbaru</h3>
                            <a href="{{ route('owner.transactions.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentTransactions as $transaction)
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->product->name ?? 'Tukar Saldo' }}</p>
                                <p class="text-xs text-gray-500">{{ $transaction->customer_phone }} • {{ $transaction->created_at->format('H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</p>
                                <p class="text-xs text-green-600">+Rp {{ number_format($transaction->profit, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Belum ada transaksi</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Monthly Summary -->
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Ringkasan Bulan Ini</h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Omzet</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($monthlyOmzet, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Laba</p>
                            <p class="text-xl sm:text-2xl font-bold text-green-600">Rp {{ number_format($monthlyProfit, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>