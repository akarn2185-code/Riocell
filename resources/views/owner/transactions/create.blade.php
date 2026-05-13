<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi Baru (POS)') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 rounded-xl text-sm">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Form Transaksi -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Input Transaksi Manual</h3>
                            <p class="text-sm text-gray-500 mt-1">Catat penjualan langsung dari konter</p>
                        </div>
                        
                        <form method="POST" action="{{ route('owner.transactions.store') }}" class="p-4 sm:p-6" id="transactionForm">
                            @csrf

                            <!-- Pilih Produk -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pilih Produk <span class="text-red-500">*</span>
                                </label>
                                <select name="product_id" id="productSelect" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        data-buy="{{ $product->buy_price }}"
                                        data-sell="{{ $product->sell_price }}"
                                        data-type="{{ $product->type }}"
                                        data-stock="{{ $product->stock }}"
                                        data-category="{{ $product->category }}">
                                        {{ $product->name }} - Rp {{ number_format($product->sell_price, 0, ',', '.') }}
                                        @if($product->type == 'fisik') (Stok: {{ $product->stock }}) @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('product_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <!-- Info Produk Terpilih -->
                            <div id="productInfo" class="hidden mb-4 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Harga Beli</p>
                                        <p class="font-semibold text-gray-900 dark:text-white" id="buyPrice">-</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Harga Jual</p>
                                        <p class="font-semibold text-gray-900 dark:text-white" id="sellPrice">-</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Profit</p>
                                        <p class="font-semibold text-green-600" id="profit">-</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Nomor Tujuan -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nomor HP Tujuan / Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="customer_phone" required placeholder="Contoh: 081234567890"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                @error('customer_phone')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <!-- Quantity -->
                            <div class="mb-4" id="quantityWrapper">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jumlah <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <p class="mt-1 text-xs text-gray-500" id="stockInfo"></p>
                                @error('quantity')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <!-- Metode Pembayaran Baru -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Metode Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <select name="payment_method" id="paymentMethod" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                    <option value="Tunai (Cash)">💵 Tunai (Cash)</option>
                                    <option value="QRIS">📱 QRIS / E-Wallet</option>
                                    <option value="Transfer Bank">💳 Transfer Bank</option>
                                </select>
                            </div>

                            <!-- Catatan (Kita sembunyikan aslinya, lalu gabung dengan metode pembayaran pakai JS) -->
                            <input type="hidden" name="notes" id="realNotes">
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Catatan Tambahan (Opsional)
                                </label>
                                <textarea id="visibleNotes" rows="2" placeholder="Tambahan info transaksi..."
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
                            </div>

                            <!-- Total -->
                            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Total Tagihan</span>
                                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="totalPrice">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-sm text-gray-500">Profit</span>
                                    <span class="text-lg font-semibold text-green-600" id="totalProfit">+Rp 0</span>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-3">
                                <button type="submit" onclick="prepareNotes()" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Transaksi
                                </button>
                                <a href="{{ route('owner.transactions.index') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium text-center">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Products -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Produk Tersedia</h3>
                        </div>
                        <div class="p-4 space-y-2 max-h-[600px] overflow-y-auto">
                            @foreach($products as $product)
                            <button type="button" onclick="selectProduct({{ $product->id }})"
                                class="w-full p-3 text-left bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $product->name }}</p>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-gray-500">{{ ucfirst($product->category) }}</span>
                                    <span class="text-sm font-semibold text-blue-600">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</span>
                                </div>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function selectProduct(productId) {
            document.getElementById('productSelect').value = productId;
            updateProductInfo();
        }

        function updateProductInfo() {
            const select = document.getElementById('productSelect');
            const option = select.options[select.selectedIndex];
            const infoDiv = document.getElementById('productInfo');
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            
            if (option.value) {
                const buyPrice = parseFloat(option.dataset.buy);
                const sellPrice = parseFloat(option.dataset.sell);
                const profit = sellPrice - buyPrice;
                const type = option.dataset.type;
                const stock = parseInt(option.dataset.stock);

                document.getElementById('buyPrice').textContent = formatRupiah(buyPrice);
                document.getElementById('sellPrice').textContent = formatRupiah(sellPrice);
                document.getElementById('profit').textContent = '+' + formatRupiah(profit);
                
                document.getElementById('totalPrice').textContent = formatRupiah(sellPrice * quantity);
                document.getElementById('totalProfit').textContent = '+' + formatRupiah(profit * quantity);

                if (type === 'fisik') {
                    document.getElementById('stockInfo').textContent = 'Stok tersedia: ' + stock;
                    document.getElementById('quantity').max = stock;
                } else {
                    document.getElementById('stockInfo').textContent = 'Produk digital (tanpa stok)';
                    document.getElementById('quantity').removeAttribute('max');
                }

                infoDiv.classList.remove('hidden');
            } else {
                infoDiv.classList.add('hidden');
                document.getElementById('totalPrice').textContent = 'Rp 0';
                document.getElementById('totalProfit').textContent = '+Rp 0';
                document.getElementById('stockInfo').textContent = '';
            }
        }

        // Script untuk menggabungkan metode pembayaran ke dalam notes
        function prepareNotes() {
            const method = document.getElementById('paymentMethod').value;
            const extraNote = document.getElementById('visibleNotes').value;
            let finalNote = "[Bayar: " + method + "]";
            
            if(extraNote.trim() !== "") {
                finalNote += " - " + extraNote;
            }
            
            document.getElementById('realNotes').value = finalNote;
        }

        document.getElementById('productSelect').addEventListener('change', updateProductInfo);
        document.getElementById('quantity').addEventListener('input', updateProductInfo);
    </script>
</x-app-layout>