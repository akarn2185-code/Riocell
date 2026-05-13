<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Riwayat Transaksi') }}
            </h2>
            <a href="{{ route('owner.transactions.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Transaksi Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-xl text-sm">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 rounded-xl text-sm">
                {{ session('error') }}
            </div>
            @endif

            <!-- Stats Hari Ini -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6">
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Omzet Hari Ini</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6">
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Laba Hari Ini</p>
                    <p class="text-lg sm:text-2xl font-bold text-green-600">Rp {{ number_format($totalProfit, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                <form method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <input type="date" name="date" value="{{ request('date') }}" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                    <div>
                        <select name="type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">Semua Tipe</option>
                            <option value="pos" {{ request('type') == 'pos' ? 'selected' : '' }}>POS (Manual)</option>
                            <option value="online" {{ request('type') == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm font-medium">
                        Filter
                    </button>
                    <a href="{{ route('owner.transactions.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium text-center">
                        Reset
                    </a>
                </form>
            </div>

            <!-- Transactions List -->
            @if($transactions->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
    <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Waktu</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">No. Tujuan</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga Jual</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Profit</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tipe</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
    </tr>
</thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->product->name ?? 'Produk Dihapus' }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($transaction->product->category ?? '-') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $transaction->customer_phone }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                    +Rp {{ number_format($transaction->profit, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $transaction->transaction_type == 'pos' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ strtoupper($transaction->transaction_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center space-x-2">
        <a href="{{ route('owner.transactions.struk.preview', $transaction) }}" 
            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Cetak Struk">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
        </a>
        <a href="{{ route('owner.transactions.struk.download', $transaction) }}" 
            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Download PDF">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </a>
    </div>
</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($transactions as $transaction)
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $transaction->product->name ?? 'Produk' }}</p>
                                <p class="text-xs text-gray-500">{{ $transaction->customer_phone }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $transaction->transaction_type == 'pos' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ strtoupper($transaction->transaction_type) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-gray-400">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                            <div class="text-right">
                                <p class="font-medium text-gray-900 dark:text-white">Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</p>
                                <p class="text-xs text-green-600">+Rp {{ number_format($transaction->profit, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="mt-3 flex gap-2">
    <a href="{{ route('owner.transactions.struk.preview', $transaction) }}" 
        class="flex-1 px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-medium text-center hover:bg-blue-200 dark:hover:bg-blue-800 transition">
        🖨️ Cetak
    </a>
    <a href="{{ route('owner.transactions.struk.download', $transaction) }}" 
        class="flex-1 px-3 py-2 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg text-xs font-medium text-center hover:bg-green-200 dark:hover:bg-green-800 transition">
        📄 PDF
    </a>
</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 sm:p-12 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada transaksi</h3>
                <p class="text-gray-500 mb-4">Mulai catat transaksi pertama Anda</p>
                <a href="{{ route('owner.transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Transaksi Baru
                </a>
            </div>
            @endif

        </div>
    </div>
        </div>

    <!-- Auto Print Popup -->
    @if(session('print_struk'))
    <div id="printModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Transaksi Berhasil!</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Apakah Anda ingin mencetak struk?</p>
                
                <div class="flex gap-3">
                    <a href="{{ route('owner.transactions.struk.print', session('print_struk')) }}" target="_blank"
                        class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium"
                        onclick="closeModal()">
                        🖨️ Print Struk
                    </a>
                    <button onclick="closeModal()" 
                        class="flex-1 px-4 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">
                        Tutup
                    </button>
                </div>
                
                <a href="{{ route('owner.transactions.struk.download', session('print_struk')) }}" 
                    class="block mt-3 text-sm text-green-600 dark:text-green-400 hover:underline"
                    onclick="closeModal()">
                    📄 Download PDF
                </a>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('printModal').style.display = 'none';
        }
    </script>
    @endif
</x-app-layout>