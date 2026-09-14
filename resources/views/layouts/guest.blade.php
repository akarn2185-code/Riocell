<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rio Cell') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Animations */
        .blob-bg {
            background-image: radial-gradient(circle at 50% 50%, rgba(37, 99, 235, 0.15) 0%, rgba(15, 23, 42, 1) 50%);
        }
        .float-slow { animation: floating 6s ease-in-out infinite; }
        .float-fast { animation: floating 4s ease-in-out infinite reverse; }

        @keyframes floating {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
    </style>
</head>
<body class="text-gray-900 antialiased selection:bg-blue-500 selection:text-white">
    <div class="min-h-screen flex">
        
        <!-- ============================================== -->
        <!-- LEFT SIDE - BRANDING (TAMPILAN BARU YANG MEWAH) -->
        <!-- ============================================== -->
        <div class="hidden lg:flex lg:w-1/2 bg-slate-950 blob-bg relative overflow-hidden items-center justify-center">
            
            <!-- Ornamen Cahaya Background (Glowing Orbs) -->
            <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-600/30 rounded-full filter blur-[100px] float-slow"></div>
            <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-cyan-500/20 rounded-full filter blur-[100px] float-fast"></div>
            
            <!-- Pattern Titik-titik (Dot Grid) -->
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 24px 24px;"></div>
            
            <div class="relative z-10 flex flex-col items-center w-full p-12 text-white max-w-lg">
                
                <!-- Logo -->
                <div class="relative mb-10 group">
                    <div class="absolute inset-0 bg-blue-500 rounded-3xl blur-lg opacity-50 group-hover:opacity-100 transition duration-500"></div>
                    <img src="{{ route('product.image', ['path' => 'products/logo_riocell.jpg']) }}" alt="Logo Rio Cell" class="relative w-24 h-24 border border-slate-700 rounded-3xl object-cover transform -rotate-6 group-hover:rotate-0 transition duration-500 shadow-2xl">
                </div>
                
                <!-- Title & Subtitle -->
                <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 tracking-tight text-center">
                    Rio <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Cell</span>
                </h1>
                <p class="text-lg text-slate-400 text-center mb-12 font-medium">Pusat Digital & Aksesoris Terpercaya</p>
                
                <!-- Feature Cards (Glassmorphism Style) -->
                <div class="w-full space-y-4">
                    
                    <!-- Feature 1 -->
                    <div class="flex items-center p-5 rounded-2xl bg-white/[0.03] border border-white/[0.08] backdrop-blur-xl hover:bg-white/[0.06] transition duration-300 group shadow-lg">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center mr-5 group-hover:scale-110 group-hover:bg-blue-500/30 transition duration-300">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg mb-0.5">Proses Instan</h3>
                            <p class="text-sm text-slate-400">Transaksi otomatis tanpa nunggu lama</p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex items-center p-5 rounded-2xl bg-white/[0.03] border border-white/[0.08] backdrop-blur-xl hover:bg-white/[0.06] transition duration-300 group shadow-lg">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center mr-5 group-hover:scale-110 group-hover:bg-emerald-500/30 transition duration-300">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg mb-0.5">Harga Terbaik</h3>
                            <p class="text-sm text-slate-400">Jaminan harga bersaing dan transparan</p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex items-center p-5 rounded-2xl bg-white/[0.03] border border-white/[0.08] backdrop-blur-xl hover:bg-white/[0.06] transition duration-300 group shadow-lg">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center mr-5 group-hover:scale-110 group-hover:bg-purple-500/30 transition duration-300">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg mb-0.5">Asisten AI 24/7</h3>
                            <p class="text-sm text-slate-400">Chatbot cerdas siap membantu kapan saja</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- RIGHT SIDE - FORM LOGIN / REGISTER             -->
        <!-- ============================================== -->
        <div class="w-full lg:w-1/2 flex flex-col bg-gray-50 dark:bg-slate-900 relative">
            
            <!-- Header Mobile (Tampil cuma di HP) -->
            <div class="lg:hidden bg-slate-950 p-8 text-white text-center relative overflow-hidden">
                <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 16px 16px;"></div>
                <img src="{{ route('product.image', ['path' => 'products/logo_riocell.jpg']) }}" alt="Logo Rio Cell" class="relative z-10 w-16 h-16 border border-slate-700 rounded-2xl object-cover mx-auto mb-4 shadow-lg">
                <h1 class="relative z-10 text-2xl font-extrabold tracking-tight">Rio Cell</h1>
            </div>

            <!-- Dark Mode Toggle Button -->
            <div class="absolute top-4 right-4 z-50">
                <button @click="darkMode = !darkMode" class="p-2.5 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full shadow-sm transition">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
            </div>

            <!-- Area Form (Isi dari Login/Register diletakkan di sini) -->
            <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer Area -->
            <div class="p-6 text-center text-sm text-slate-500 dark:text-slate-500 font-medium">
                <p>&copy; {{ date('Y') }} Rio Cell. All rights reserved.</p>
            </div>
            
        </div>
    </div>
</body>
</html>