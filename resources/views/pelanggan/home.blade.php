<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Beranda') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-green-500 to-teal-600 overflow-hidden shadow-sm rounded-xl sm:rounded-2xl mb-6">
                <div class="p-4 sm:p-6 text-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="mt-1 sm:mt-2 text-green-100 text-sm sm:text-base">Temukan pulsa, paket data, dan aksesoris HP terbaik di Rio Cell.</p>
                    </div>
                    
                    @if(Auth::user()->avatar)
                        <img class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover shadow-lg border-2 border-white/50" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                    @else
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white/20 rounded-full flex items-center justify-center text-white text-2xl sm:text-3xl font-bold shadow-lg border-2 border-white/50">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('pelanggan.catalog', ['category' => 'pulsa']) }}" class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Pulsa</span>
                </a>
                <a href="{{ route('pelanggan.catalog', ['category' => 'paket_data']) }}" class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Data</span>
                </a>
                <a href="{{ route('pelanggan.catalog', ['category' => 'e_wallet']) }}" class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">E-Wallet</span>
                </a>
                <a href="{{ route('pelanggan.catalog', ['category' => 'aksesoris']) }}" class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col items-center hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Aksesoris</span>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
                <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-800/50">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                            Produk Terbaru
                        </h3>
                    </div>
                    <a href="{{ route('pelanggan.catalog') }}" class="text-sm text-blue-600 dark:text-blue-400 font-semibold hover:underline flex items-center gap-1 transition">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="p-4 sm:p-6">
                    @if($latestProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($latestProducts as $product)
                        <div class="flex items-center justify-between p-4 rounded-2xl border-2 border-transparent bg-gray-50 dark:bg-gray-800/40 hover:bg-white dark:hover:bg-gray-800 hover:border-blue-100 dark:hover:border-blue-900/50 hover:shadow-lg transition-all duration-300 group">
                            
                            <div class="flex items-center min-w-0 flex-1">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex-shrink-0 shadow-sm overflow-hidden bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 relative">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br 
                                            @if($product->category == 'pulsa') from-red-500 to-red-600
                                            @elseif($product->category == 'paket_data') from-blue-500 to-blue-600
                                            @elseif($product->category == 'e_wallet') from-green-500 to-green-600
                                            @else from-purple-500 to-purple-600 @endif">
                                            <span class="text-white font-bold text-xl uppercase">{{ substr($product->category, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-4 sm:ml-5 min-w-0 flex-1">
                                    <h4 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $product->name }}
                                    </h4>
                                    <span class="inline-block mt-1.5 px-2.5 py-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-md">
                                        {{ str_replace('_', ' ', $product->category) }}
                                    </span>
                                </div>
                            </div>

                            <div class="ml-4 flex flex-col sm:flex-row items-end sm:items-center gap-3 sm:gap-6 flex-shrink-0">
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5 hidden sm:block font-medium">Harga Spesial</p>
                                    <p class="text-lg sm:text-2xl font-extrabold text-blue-600 dark:text-blue-400">
                                        Rp {{ number_format($product->sell_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <a href="{{ route('pelanggan.order.create', $product) }}" class="px-4 py-2.5 sm:px-6 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/40 transform hover:-translate-y-1 transition-all duration-300 flex items-center gap-2 active:scale-95">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span class="hidden sm:inline">Beli Sekarang</span>
                                    <span class="sm:hidden">Beli</span>
                                </a>
                            </div>

                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Belum ada produk terbaru saat ini.</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 sm:p-6 mb-8">
                <div class="flex items-start">
                    <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <h4 class="text-sm sm:text-base font-semibold text-blue-900 dark:text-blue-100">Informasi Penting</h4>
                        <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300 mt-1">Pembayaran melalui QRIS akan diverifikasi otomatis oleh sistem. Pastikan nominal transfer sesuai dengan total tagihan agar pesanan diproses lebih cepat.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>