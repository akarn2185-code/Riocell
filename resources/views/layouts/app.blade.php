<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#3B82F6">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="format-detection" content="telephone=no">

        <title>{{ config('app.name', 'Rio Cell') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Dark Mode Script (Load Early) -->
        <script>
            // Check localStorage atau system preference
            if (localStorage.getItem('darkMode') === 'true' || 
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <style>
            /* Smooth transitions for dark mode */
            html {
                transition: background-color 0.3s ease, color 0.3s ease;
            }
            
            /* Better touch targets for mobile */
            @media (max-width: 640px) {
                button, a, input, select, textarea {
                    min-height: 44px;
                }
            }

            /* Prevent horizontal scroll on mobile */
            body {
                overflow-x: hidden;
            }

            /* Safe area for iPhone notch */
            @supports (padding: max(0px)) {
                .safe-area-inset {
                    padding-left: max(1rem, env(safe-area-inset-left));
                    padding-right: max(1rem, env(safe-area-inset-right));
                    padding-bottom: max(1rem, env(safe-area-inset-bottom));
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="safe-area-inset">
                {{ $slot }}
            </main>

            <!-- Chat Widget (Hanya untuk pelanggan & disembunyikan di halaman Full Chat) -->
            @auth
                @if(auth()->user()->role === 'pelanggan' && !request()->routeIs('pelanggan.chat'))
                    @include('components.chat-widget')
                @endif
            @endauth
        </div>

        <!-- Dark Mode Toggle Script -->
        <script>
            function toggleDarkMode() {
                const html = document.documentElement;
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
            }
        </script>
    </body>
</html>