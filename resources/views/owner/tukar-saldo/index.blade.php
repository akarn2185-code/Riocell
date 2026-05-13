<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tukar Saldo ke Tunai') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-xl text-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Kalkulator Tukar Saldo -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-500 to-emerald-600">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Kalkulator Tukar Saldo
                        </h3>
                        <p class="text-green-100 text-sm mt-1">Hitung jumlah uang yang diterima pelanggan</p>
                    </div>
                    
                    <form method="POST" action="{{ route('owner.tukar-saldo.store') }}" class="p-4 sm:p-6">
                        @csrf

                        <!-- Nomor HP -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomor HP Pelanggan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="customer_phone" required placeholder="081234567890"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Jenis E-Wallet -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jenis E-Wallet <span class="text-red-500">*</span>
                            </label>
                            <select name="ewallet_type" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="DANA">DANA</option>
                                <option value="OVO">OVO</option>
                                <option value="GoPay">GoPay</option>
                                <option value="ShopeePay">ShopeePay</option>
                                <option value="LinkAja">LinkAja</option>
                            </select>
                        </div>

                        <!-- Nominal Saldo -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nominal Saldo <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="amount" id="amount" required min="10000" placeholder="100000"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                oninput="calculateFee()">
                        </div>

                        <!-- Fee Percentage -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Persentase Fee (%) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="fee_percentage" id="fee_percentage" required min="0" max="100" value="5" step="0.5"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                oninput="calculateFee()">
                            <p class="text-xs text-gray-500 mt-1">Biasanya 3-5% dari nominal</p>
                        </div>

                        <!-- Hasil Kalkulasi -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">Saldo diterima:</span>
                                    <span class="font-medium text-gray-900 dark:text-white" id="displayAmount">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">Potongan fee:</span>
                                    <span class="font-medium text-red-600" id="displayFee">- Rp 0</span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                                <div class="flex justify-between">
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Uang ke pelanggan:</span>
                                    <span class="text-xl font-bold text-green-600" id="displayReceives">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500 dark:text-gray-400">Keuntungan Anda:</span>
                                    <span class="font-medium text-blue-600" id="displayProfit">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Transaksi
                        </button>
                    </form>
                </div>

                <!-- Riwayat Tukar Saldo -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Riwayat Tukar Saldo</h3>
                    </div>
                    
                    @if($transactions->count() > 0)
                    <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[500px] overflow-y-auto">
                        @foreach($transactions as $transaction)
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->customer_phone }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $transaction->notes }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-green-600">+Rp {{ number_format($transaction->profit, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p>Belum ada transaksi tukar saldo</p>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        function formatRupiah(num) {
            return 'Rp ' + num.toLocaleString('id-ID');
        }

        function calculateFee() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const feePercentage = parseFloat(document.getElementById('fee_percentage').value) || 0;
            const fee = (amount * feePercentage) / 100;
            const customerReceives = amount - fee;

            document.getElementById('displayAmount').textContent = formatRupiah(amount);
            document.getElementById('displayFee').textContent = '- ' + formatRupiah(fee);
            document.getElementById('displayReceives').textContent = formatRupiah(customerReceives);
            document.getElementById('displayProfit').textContent = formatRupiah(fee);
        }
    </script>
</x-app-layout>