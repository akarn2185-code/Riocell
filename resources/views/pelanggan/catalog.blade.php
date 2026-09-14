<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Katalog Produk') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                <form method="GET" action="{{ route('pelanggan.catalog') }}" class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
                    </div>
                    <div class="flex gap-2 sm:gap-3">
                        <select name="category" class="flex-1 sm:flex-none rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">Semua Kategori</option>
                            <option value="pulsa" {{ request('category') == 'pulsa' ? 'selected' : '' }}>Pulsa</option>
                            <option value="paket_data" {{ request('category') == 'paket_data' ? 'selected' : '' }}>Paket Data</option>
                            <option value="e_wallet" {{ request('category') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                            <option value="aksesoris" {{ request('category') == 'aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md font-medium">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                @foreach($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 group">
                    
                    <div class="relative h-40 sm:h-48 bg-gray-100 dark:bg-gray-900 flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ route('product.image', ['path' => $product->image]) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br 
                                @if($product->category == 'pulsa') from-red-500 to-red-600
                                @elseif($product->category == 'paket_data') from-blue-500 to-blue-600
                                @elseif($product->category == 'e_wallet') from-green-500 to-green-600
                                @else from-purple-500 to-purple-600 @endif">
                                <span class="text-white/20 text-6xl font-bold uppercase">{{ substr($product->category, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        <div class="absolute top-2 left-2">
                            <span class="px-2 py-1 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm text-[10px] font-bold rounded-lg shadow-sm text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                {{ str_replace('_', ' ', $product->category) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm sm:text-base mb-1 line-clamp-2 h-10 sm:h-12">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-blue-600 dark:text-blue-400 font-extrabold text-base sm:text-lg">
                                Rp{{ number_format($product->sell_price, 0, ',', '.') }}
                            </span>
                        </div>

                        @if($product->stock > 0 || $product->category != 'aksesoris')
                            <a href="{{ route('pelanggan.order.create', $product) }}" 
                                class="block w-full py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-center rounded-xl text-sm font-bold shadow-lg shadow-blue-500/30 transition transform active:scale-95">
                                Pesan Sekarang
                            </a>
                        @else
                            <button disabled class="w-full py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-xl text-sm font-bold cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 sm:p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Produk tidak ditemukan</h3>
                <p class="text-gray-500 dark:text-gray-400">Coba ubah filter atau kata kunci pencarian Anda</p>
                <a href="{{ route('pelanggan.catalog') }}" class="mt-4 inline-block text-blue-600 font-medium hover:underline">Reset Pencarian</a>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>