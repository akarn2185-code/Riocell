<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kelola Produk') }}
            </h2>
            <a href="{{ route('owner.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium flex items-center shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-xl text-sm shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col group hover:shadow-md transition">
                    
                    <div class="relative h-48 bg-gray-100 dark:bg-gray-900 flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="flex flex-col items-center text-gray-400">
                                <svg class="w-12 h-12 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs uppercase font-semibold">No Image</span>
                            </div>
                        @endif
                        
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 {{ $product->is_active ? 'bg-green-500' : 'bg-red-500' }} text-white text-[10px] font-bold rounded-md shadow-sm uppercase tracking-wider">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded">
                                {{ $categories[$product->category] ?? $product->category }}
                            </span>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                {{ $product->type }}
                            </span>
                        </div>

                        <h3 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $product->name }}</h3>
                        
                        <div class="mt-auto space-y-1">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Harga Beli:</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Rp {{ number_format($product->buy_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-medium">Harga Jual:</span>
                                <span class="font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-xs pt-1 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-gray-500">Stok:</span>
                                <span class="font-bold {{ $product->stock <= 5 ? 'text-red-500' : 'text-gray-700 dark:text-gray-300' }}">
                                    {{ $product->stock }} Unit
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('owner.products.edit', $product) }}" class="flex-1 px-3 py-2 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-lg text-sm font-medium text-center hover:bg-blue-200 dark:hover:bg-blue-800/50 transition">
                                Edit
                            </a>
                            <form action="{{ route('owner.products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-200 dark:hover:bg-red-800/50 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada produk yang ditambahkan</p>
                    <a href="{{ route('owner.products.create') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium shadow-md">
                        Tambah Produk Pertama
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>