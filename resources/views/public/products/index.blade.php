<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Produk - Rio Cell</title>
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
                    <img src="{{ asset('img/logo_riocell.jpg') }}" alt="Logo Rio Cell" class="w-10 h-10 rounded-xl object-cover shadow-lg">
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Rio Cell</span>
                </a>
                <div class="flex items-center space-x-4">
                    <a href="/produk" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium">Produk</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 transition">Login</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-lg shadow-md transition">Daftar</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">📦 Daftar Produk</h1>
                <p class="text-gray-600 dark:text-gray-400">Lihat semua produk kami yang tersedia tanpa perlu login</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-8">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Produk</label>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau deskripsi..." class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-4 py-2 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                            <select name="category" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ $category === $cat ? 'selected' : '' }}>
                                        {{ $categoryLabels[$cat] ?? ucfirst($cat) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition shadow-md hover:shadow-lg">
                                🔍 Cari
                            </button>
                            <a href="/produk" class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-2 px-4 rounded-lg transition text-center">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach($products as $product)
                        <a href="{{ route('products.show', $product) }}" class="group block bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1">
                            <div class="relative h-48 bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ route('product.image', ['path' => $product->image]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                @else
                                    <div class="text-6xl">{{ $categoryLabels[$product->category] ? substr($categoryLabels[$product->category], 0, 1) : '📦' }}</div>
                                @endif
                            </div>

                            <div class="p-4">
                                <div class="mb-2">
                                    <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                        {{ $categoryLabels[$product->category] ?? ucfirst($product->category) }}
                                    </span>
                                </div>

                                <h3 class="font-bold text-gray-900 dark:text-white mb-1 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                    {{ $product->name }}
                                </h3>

                                <div class="flex items-baseline gap-2 mb-3">
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                        Rp {{ number_format($product->sell_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    @if($product->category == 'aksesoris')
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            📦 {{ $product->stock }} Stok
                                        </span>
                                        <span class="text-xs font-semibold {{ $product->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            ⚡ Digital
                                        </span>
                                        <span class="text-xs font-semibold text-green-600 dark:text-green-400">
                                            Tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="flex justify-center mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
                    <div class="text-6xl mb-4">😕</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Maaf, produk dengan kriteria pencarian Anda tidak tersedia saat ini.
                    </p>
                    <a href="/produk" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition">
                        Kembali ke Semua Produk
                    </a>
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