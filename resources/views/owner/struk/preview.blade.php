<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('owner.transactions.index') }}" class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Preview Struk #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Action Buttons -->
            <div class="mb-6 flex flex-wrap gap-3 justify-center sm:justify-start">
                <a href="{{ route('owner.transactions.struk.print', $transaction) }}" target="_blank"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Struk
                </a>
                <a href="{{ route('owner.transactions.struk.download', $transaction) }}"
                    class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
            </div>

            <!-- Struk Preview Container -->
            <div class="flex justify-center">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden" style="width: 320px;">
                    <!-- Header Label -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-4 py-3 text-center">
                        <p class="text-white text-sm font-medium">Preview Struk Transaksi</p>
                    </div>

                    <!-- Struk Content -->
                    <div class="p-6" style="font-family: 'Courier New', Courier, monospace; font-size: 12px;">
                        
                        <!-- Header Toko -->
                        <div class="text-center border-b-2 border-dashed border-gray-400 pb-4 mb-4">
                            <div class="text-3xl font-bold text-blue-600 mb-1">RC</div>
                            <div class="text-lg font-bold text-gray-800">RIO CELL</div>
                            <div class="text-xs text-gray-500 mt-1">Pusat Pulsa & Aksesoris HP</div>
                            <div class="text-xs text-gray-500">Jl. Contoh No. 123, Kota</div>
                            <div class="text-xs text-gray-500">Telp: 081234567890</div>
                        </div>

                        <!-- Info Transaksi -->
                        <div class="mb-4 text-xs">
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-500">No. Transaksi</span>
                                <span class="font-bold text-gray-800">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-500">Tanggal</span>
                                <span class="text-gray-800">{{ $transaction->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-500">Waktu</span>
                                <span class="text-gray-800">{{ $transaction->created_at->format('H:i:s') }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-500">Kasir</span>
                                <span class="text-gray-800">Owner</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Customer</span>
                                <span class="text-gray-800">{{ $transaction->customer_phone }}</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-solid border-gray-800 my-3"></div>

                        <!-- Produk -->
                        <div class="mb-3">
                            <div class="font-bold text-gray-800 mb-1">{{ $transaction->product->name ?? 'Tukar Saldo' }}</div>
                            <div class="flex justify-between text-xs text-gray-600">
                                <span>{{ $transaction->quantity }} x Rp {{ number_format($transaction->sell_price / $transaction->quantity, 0, ',', '.') }}</span>
                                <span>Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</span>
                            </div>
                            @if($transaction->notes)
                            <div class="text-xs text-gray-500 italic mt-1">{{ $transaction->notes }}</div>
                            @endif
                        </div>

                        <div class="border-t border-dashed border-gray-400 my-3"></div>

                        <!-- Total -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="text-gray-800">Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-base border-t-2 border-solid border-gray-800 pt-2 mt-2">
                                <span class="text-gray-800">TOTAL</span>
                                <span class="text-gray-800">Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-solid border-gray-800 my-3"></div>

                        <!-- Info Pembayaran -->
                        <div class="text-center text-xs text-gray-600 mb-3">
                            <div>Metode: <strong>{{ $transaction->transaction_type == 'pos' ? 'TUNAI' : 'ONLINE' }}</strong></div>
                            <div class="mt-1 bg-gray-100 py-1 px-2 rounded text-xs">
                                ID: TRX{{ str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>

                        <div class="border-t-2 border-dashed border-gray-400 my-3"></div>

                        <!-- Footer -->
                        <div class="text-center">
                            <div class="text-sm font-bold text-gray-800 mb-1">✨ TERIMA KASIH ✨</div>
                            <div class="text-xs text-gray-500">Telah berbelanja di Rio Cell</div>
                            <div class="text-xs text-gray-400 mt-2">Barang yang sudah dibeli tidak</div>
                            <div class="text-xs text-gray-400">dapat ditukar/dikembalikan</div>
                            <div class="text-xs text-gray-300 mt-3">{{ now()->format('d/m/Y H:i:s') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Details Card -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">📋 Detail Transaksi</h3>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Produk</p>
                            <p class="font-medium text-gray-900 dark:text-white mt-1">{{ $transaction->product->name ?? 'Tukar Saldo' }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Customer</p>
                            <p class="font-medium text-gray-900 dark:text-white mt-1">{{ $transaction->customer_phone }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Tipe</p>
                            <p class="mt-1">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $transaction->transaction_type == 'pos' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                    {{ strtoupper($transaction->transaction_type) }}
                                </span>
                            </p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Harga Beli (Modal)</p>
                            <p class="font-medium text-gray-900 dark:text-white mt-1">Rp {{ number_format($transaction->buy_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Harga Jual</p>
                            <p class="font-medium text-gray-900 dark:text-white mt-1">Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Profit</p>
                            <p class="font-bold text-green-600 mt-1">+ Rp {{ number_format($transaction->profit, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6 text-center">
                <a href="{{ route('owner.transactions.index') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Transaksi
                </a>
            </div>

        </div>
    </div>
</x-app-layout>