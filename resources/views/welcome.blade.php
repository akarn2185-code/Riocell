<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#3B82F6">
    <meta name="description" content="Rio Cell - Pusat Pulsa, Paket Data, E-Wallet & Aksesoris HP Terlengkap">
    
    <title>Rio Cell - Pusat Pulsa & Aksesoris HP</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .hero-gradient-dark { background: linear-gradient(135deg, #1e3a5f 0%, #2d1b4e 100%); }
        .floating { animation: floating 3s ease-in-out infinite; }
        @keyframes floating { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        .fade-in { animation: fadeIn 0.8s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">RC</span>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white">Rio Cell</span>
                </a>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <button @click="darkMode = !darkMode" class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition">
                        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-3 sm:px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-3 sm:px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-lg shadow-md hover:shadow-lg transition">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-24 pb-12 sm:pt-32 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 hero-gradient dark:hero-gradient-dark opacity-10"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-10 floating"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-10 floating" style="animation-delay: 1s;"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center fade-in">
                <div class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/50 rounded-full mb-6">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Buka Setiap Hari 08:00 - 21:00</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white mb-6">
                    <span class="block">Pulsa & Paket Data</span>
                    <span class="block bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Murah & Cepat</span>
                </h1>
                
                <p class="max-w-2xl mx-auto text-lg sm:text-xl text-gray-600 dark:text-gray-300 mb-8">
                    Rio Cell menyediakan pulsa semua operator, paket data, top-up e-wallet, dan aksesoris HP dengan harga terbaik!
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="/produk" class="w-full sm:w-auto px-8 py-4 text-lg font-semibold text-white bg-green-600 hover:bg-green-700 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">👀 Lihat Semua Produk</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">Masuk Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">🚀 Mulai Belanja</a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 text-lg font-semibold text-gray-700 dark:text-white bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 rounded-xl shadow-md hover:shadow-lg transition">Sudah Punya Akun?</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 sm:py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">Layanan Kami</h2>
                <p class="text-gray-600 dark:text-gray-400">Semua kebutuhan digital dan aksesoris dalam satu tempat</p>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Pulsa -->
                <div class="group bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-800/30 p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-red-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">Pulsa</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Semua operator tersedia dengan harga bersaing</p>
                </div>
                <!-- Paket Data -->
                <div class="group bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">Paket Data</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Kuota internet murah untuk semua kebutuhan</p>
                </div>
                <!-- E-Wallet -->
                <div class="group bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-green-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">E-Wallet</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Top-up DANA, OVO, GoPay, ShopeePay</p>
                </div>
                <!-- Aksesoris -->
                <div class="group bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 p-6 sm:p-8 rounded-2xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-purple-500 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">Aksesoris</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Case, charger, kabel data, dan lainnya</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Maps Section -->
    <section class="py-12 sm:py-20 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">📍 Lokasi Rio Cell</h2>
                <p class="text-gray-600 dark:text-gray-400">Kunjungi konter fisik kami untuk layanan langsung</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-2 sm:p-4 rounded-3xl shadow-xl overflow-hidden">
                <iframe 
                    src="https://maps.google.com/maps?q=-6.940310,107.581500&hl=id&z=16&output=embed" 
                    width="100%" height="450" style="border:0; border-radius: 1.5rem;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-gray-950 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-lg">RC</span>
                        </div>
                        <span class="text-xl font-bold">Rio Cell</span>
                    </div>
                    <p class="text-gray-400 text-sm">Pusat pulsa, paket data, e-wallet, dan aksesoris HP terlengkap dengan harga terbaik.</p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-blue-400">Kontak & Alamat</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Soekarno-Hatta<br>(Seberang PO Bus Primajasa),<br>Babakan Ciparay, Bandung</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            0831-1318-8047
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Buka: 08:00 - 21:00 WIB
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-blue-400">Akses Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition flex items-center">→ Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition flex items-center">→ Daftar Akun</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Rio Cell. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>