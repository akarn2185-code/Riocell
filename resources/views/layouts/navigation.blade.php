<nav x-data="{ open: false, darkMode: localStorage.getItem('darkMode') === 'true' }" 
     x-init="$watch('darkMode', val => { localStorage.setItem('darkMode', val); document.documentElement.classList.toggle('dark', val); })"
     class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->role === 'owner' ? route('owner.dashboard') : route('pelanggan.home') }}" class="flex items-center">
                        <img src="{{ route('product.image', ['path' => 'products/logo_riocell.jpg']) }}" alt="Logo Rio Cell" class="w-10 h-10 rounded-lg object-cover shadow-lg">
                        <span class="ml-3 text-xl font-bold text-gray-800 dark:text-white hidden sm:block">Rio Cell</span>
                    </a>
                </div>

                <!-- Navigation Links Owner -->
                @if(auth()->user()->role === 'owner')
                <div class="hidden md:flex md:space-x-4 md:-my-px md:ms-10">
                    <x-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('owner.transactions.index')" :active="request()->routeIs('owner.transactions.*')">
                        Transaksi
                    </x-nav-link>
                    <x-nav-link :href="route('owner.products.index')" :active="request()->routeIs('owner.products.*')">
                        Produk
                    </x-nav-link>
                    <x-nav-link :href="route('owner.orders.index')" :active="request()->routeIs('owner.orders.*')">
                        Pesanan
                    </x-nav-link>
                    <x-nav-link :href="route('owner.reports.index')" :active="request()->routeIs('owner.reports.*')">
                        Laporan
                    </x-nav-link>
                    <x-nav-link :href="route('owner.chatlogs.index')" :active="request()->routeIs('owner.chatlogs.*')">
                        Chat AI
                    </x-nav-link>
                </div>
                @endif

                <!-- Navigation Links Pelanggan -->
                @if(auth()->user()->role === 'pelanggan')
                <div class="hidden md:flex md:space-x-4 md:-my-px md:ms-10">
                    <x-nav-link :href="route('pelanggan.home')" :active="request()->routeIs('pelanggan.home')">
                        Beranda
                    </x-nav-link>
                    <x-nav-link :href="route('pelanggan.catalog')" :active="request()->routeIs('pelanggan.catalog')">
                        Katalog
                    </x-nav-link>
                    <x-nav-link :href="route('pelanggan.orders')" :active="request()->routeIs('pelanggan.orders')">
                        Pesanan Saya
                    </x-nav-link>
                </div>
                @endif
            </div>

            <!-- Right Side -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                    <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 rounded-md transition">
                            
                            <!-- BUNDARAN FOTO PROFIL (DESKTOP) -->
                            @if(Auth::user()->avatar)
                                <img class="w-8 h-8 rounded-full object-cover border border-gray-300 dark:border-gray-600 shadow-sm mr-2" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-sm mr-2">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif

                            <span class="hidden lg:block">{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b dark:border-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ Auth::user()->role === 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }} mt-1">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden space-x-2">
                <button @click="darkMode = !darkMode" class="p-2 text-gray-500 dark:text-gray-400 rounded-lg">
                    <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>
                <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-cloak class="md:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700">
        @if(auth()->user()->role === 'owner')
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('owner.dashboard')" :active="request()->routeIs('owner.dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('owner.transactions.index')" :active="request()->routeIs('owner.transactions.*')">Transaksi</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('owner.products.index')" :active="request()->routeIs('owner.products.*')">Produk</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('owner.orders.index')" :active="request()->routeIs('owner.orders.*')">Pesanan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('owner.reports.index')" :active="request()->routeIs('owner.reports.*')">Laporan</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('owner.chatlogs.index')" :active="request()->routeIs('owner.chatlogs.*')">Chat AI</x-responsive-nav-link>
        </div>
        @endif

        @if(auth()->user()->role === 'pelanggan')
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('pelanggan.home')" :active="request()->routeIs('pelanggan.home')">Beranda</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pelanggan.catalog')" :active="request()->routeIs('pelanggan.catalog')">Katalog</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pelanggan.orders')" :active="request()->routeIs('pelanggan.orders')">Pesanan Saya</x-responsive-nav-link>
        </div>
        @endif

        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                
                <!-- BUNDARAN FOTO PROFIL (MOBILE) -->
                @if(Auth::user()->avatar)
                    <img class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                @else
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-lg shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif

                <div class="ml-3">
                    <div class="font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>[x-cloak] { display: none !important; }</style>