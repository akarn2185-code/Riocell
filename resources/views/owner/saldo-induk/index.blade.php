<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Saldo Induk') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-xl text-sm">
                {{ session('success') }}
            </div>
            @endif

            <!-- Current Balance -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-xl shadow-lg p-6 sm:p-8 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-200 text-sm">Saldo Induk Saat Ini</p>
                        <p class="text-3xl sm:text-4xl font-bold mt-1">Rp {{ number_format($saldoInduk->balance, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                </div>
                @if($saldoInduk->last_deposit_at)
                <p class="text-purple-200 text-sm mt-4">
                    Deposit terakhir: Rp {{ number_format($saldoInduk->last_deposit, 0, ',', '.') }} 
                    ({{ $saldoInduk->last_deposit_at->diffForHumans() }})
                </p>
                @endif
            </div>

            <!-- Deposit Form -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Tambah Saldo Induk</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Isi saldo untuk transaksi produk digital</p>
                </div>
                
                <form method="POST" action="{{ route('owner.saldo-induk.deposit') }}" class="p-4 sm:p-6">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jumlah Deposit
                        </label>
                        <input type="number" name="amount" id="depositAmount" required min="10000" placeholder="500000"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-lg">
                        @error('amount')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <!-- Quick Amount Buttons -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Pilih cepat:</p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            <button type="button" onclick="setAmount(100000)" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Rp 100rb
                            </button>
                            <button type="button" onclick="setAmount(500000)" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Rp 500rb
                            </button>
                            <button type="button" onclick="setAmount(1000000)" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Rp 1 Juta
                            </button>
                            <button type="button" onclick="setAmount(5000000)" class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                Rp 5 Juta
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Saldo
                    </button>
                </form>
            </div>

            <!-- Info -->
            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Informasi</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                            Saldo induk akan berkurang otomatis saat Anda mencatat transaksi produk digital (pulsa, paket data, e-wallet).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back to Dashboard -->
            <div class="mt-6 text-center">
                <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>

    <script>
        function setAmount(amount) {
            document.getElementById('depositAmount').value = amount;
        }
    </script>
</x-app-layout>