<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - Rio Cell</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">

    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">RC</span>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Rio Cell</span>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="/produk" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">← Kembali ke Produk</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 transition">Login</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-24 pb-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="/produk" class="text-blue-600 dark:text-blue-400 hover:underline">← Kembali ke Produk</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 sm:p-8 flex items-center justify-center min-h-96 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain max-h-96 hover:scale-105 transition duration-500">
                    @else
                        <div class="text-center">
                            <div class="text-8xl mb-4">{{ $categoryLabels[$product->category] ? substr($categoryLabels[$product->category], 0, 1) : '📦' }}</div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium tracking-wider uppercase">Tidak ada gambar</p>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div>
                        <span class="inline-block text-sm font-semibold px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                            {{ $categoryLabels[$product->category] ?? ucfirst($product->category) }}
                        </span>
                    </div>

                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg p-6 border border-green-200 dark:border-green-800">
                        <div class="flex items-baseline gap-3">
                            <span class="text-5xl font-bold text-green-600 dark:text-green-400">
                                Rp {{ number_format($product->sell_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    @if($product->description)
                        <div>
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">Deskripsi</h3>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>
                    @endif

                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Status Produk</span>
                            @if($product->category == 'aksesoris')
                                <span class="px-4 py-1 {{ $product->stock > 0 ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }} rounded-full text-xs font-bold uppercase tracking-widest">
                                    {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            @else
                                <span class="px-4 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 rounded-full text-xs font-bold uppercase tracking-widest">
                                    Tersedia
                                </span>
                            @endif
                        </div>
                        @if($product->category == 'aksesoris')
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $product->stock }} Unit
                            </p>
                        @else
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                Produk Digital (Non-Fisik)
                            </p>
                        @endif
                    </div>

                    <div class="space-y-3 pt-4">
                        @auth
                            @if(auth()->user()->role === 'pelanggan' && ($product->stock > 0 || $product->category != 'aksesoris'))
                                <a href="{{ route('pelanggan.order.create', $product) }}" class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition text-center">
                                    🛒 Pesan Sekarang
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition text-center">
                                🛒 Login untuk Memesan
                            </a>
                        @endauth
                        <a href="/produk" class="block w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-3 px-6 rounded-lg transition text-center">
                            ← Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>

            @if($relatedProducts->count() > 0)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Produk Serupa</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('products.show', $related) }}" class="group block bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1">
                                <div class="relative h-40 bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @else
                                        <div class="text-5xl">📦</div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 line-clamp-2 h-10 group-hover:text-blue-600 transition">{{ $related->name }}</h3>
                                    <p class="text-green-600 dark:text-green-400 font-bold">Rp {{ number_format($related->sell_price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </main>

    <footer class="bg-gray-900 dark:bg-black text-white mt-16 py-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="font-bold text-lg mb-4">Rio Cell</h3>
                    <p class="text-gray-400 text-sm">Pusat Pulsa, Paket Data, E-Wallet & Aksesoris HP Terlengkap</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="/" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="/produk" class="hover:text-white transition">Produk</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Hubungi Kami</h4>
                    <p class="text-sm text-gray-400">Email: info@riocell.com</p>
                    <p class="text-sm text-gray-400">Telepon: +62 XXX XXXX XXXX</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-6 text-center text-sm text-gray-400">
                <p>&copy; 2026 Rio Cell. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

</body>
</html>