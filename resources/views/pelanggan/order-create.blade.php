<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if ($errors->any())
            <div class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Gagal memproses pesanan:</h3>
                        <ul class="mt-1 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex-shrink-0 flex items-center justify-center shadow-lg overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br 
                                    @if($product->category == 'pulsa') from-red-500 to-red-600
                                    @elseif($product->category == 'paket_data') from-blue-500 to-blue-600
                                    @elseif($product->category == 'e_wallet') from-green-500 to-green-600
                                    @else from-purple-500 to-purple-600
                                    @endif">
                                    <span class="text-white text-2xl font-bold uppercase">{{ substr($product->category, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="ml-4 sm:ml-6">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h3>
                            <p class="text-blue-600 dark:text-blue-400 font-bold text-lg">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</p>
                            <span class="inline-block px-2 py-0.5 mt-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-[10px] font-bold uppercase rounded tracking-widest">
                                {{ str_replace('_', ' ', $product->category) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Pengisian</h3>
                </div>

                <form id="orderForm" method="POST" action="{{ route('pelanggan.order.store', $product) }}" class="p-4 sm:p-6">
                    @csrf
                    
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="notes" id="realNotes">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                @if($product->category == 'aksesoris') Nomor HP Penerima @else Nomor HP / ID Tujuan @endif
                            </label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone', Auth::user()->phone) }}" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500 italic">Pastikan nomor sudah benar.</p>
                        </div>

                        @if($product->category == 'aksesoris')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Metode Pengambilan</label>
                            <select id="deliveryMethodSelect" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                onchange="toggleAddressField(this.value)">
                                <option value="Ambil di Konter">Ambil di Konter (Gratis)</option>
                                <option value="Kirim via Kurir">Kirim via Kurir (Bandung Only)</option>
                            </select>
                        </div>

                        <div id="addressField" class="hidden animate-fadeIn">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap Pengiriman</label>
                            <textarea id="deliveryAddress" rows="3" placeholder="Jl. Nama Jalan, No. Rumah, RT/RW, Kecamatan..."
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500"></textarea>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan (Opsional)</label>
                            <textarea id="visibleNotes" rows="2" placeholder="Contoh: Kirim setelah jam 5 sore..."
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Metode Pembayaran</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <label class="relative flex items-center p-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700/50 transition">
                                    <input type="radio" name="payment_method_ui" value="QRIS" checked class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm font-bold text-gray-700 dark:text-gray-300">QRIS</span>
                                </label>
                                <label class="relative flex items-center p-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700/50 transition">
                                    <input type="radio" name="payment_method_ui" value="Transfer Bank" class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm font-bold text-gray-700 dark:text-gray-300">Transfer Bank</span>
                                </label>
                                <label class="relative flex items-center p-3 border-2 border-gray-100 dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700/50 transition">
                                    <input type="radio" name="payment_method_ui" value="COD" class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm font-bold text-gray-700 dark:text-gray-300">Konter / COD</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="button" id="btnSubmit" onclick="prosesPesanan()" class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold shadow-xl shadow-blue-500/20 transition transform active:scale-95">
                            Konfirmasi & Lanjut Bayar
                        </button>
                        <a href="{{ route('pelanggan.catalog') }}" class="block text-center mt-4 text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                            Batal & Kembali
                        </a>
                    </div>
                </form>
            </div>

            <script>
                function toggleAddressField(val) {
                    const addressField = document.getElementById('addressField');
                    if (addressField) {
                        if (val === 'Kirim via Kurir') {
                            addressField.classList.remove('hidden');
                        } else {
                            addressField.classList.add('hidden');
                        }
                    }
                }

                function prosesPesanan() {
                    const form = document.getElementById('orderForm');
                    
                    if (!form.reportValidity()) {
                        return; 
                    }

                    const paymentMethod = document.querySelector('input[name="payment_method_ui"]:checked');
                    const paymentVal = paymentMethod ? paymentMethod.value : 'QRIS';

                    const deliveryEl = document.getElementById('deliveryMethodSelect');
                    const deliveryMethod = deliveryEl ? deliveryEl.value : 'Digital';

                    const noteEl = document.getElementById('visibleNotes');
                    const extraNote = noteEl ? noteEl.value : '';
                    
                    const addressEl = document.getElementById('deliveryAddress');
                    const deliveryAddress = addressEl ? addressEl.value : '';
                    
                    let finalNote = `[Bayar: ${paymentVal}] | [Kirim: ${deliveryMethod}]`;
                    
                    if (deliveryMethod === 'Kirim via Kurir' && deliveryAddress.trim() === '') {
                        alert('Mohon isi Alamat Lengkap Pengiriman terlebih dahulu!');
                        if (addressEl) addressEl.focus();
                        return;
                    }

                    if (deliveryMethod === 'Kirim via Kurir') {
                        finalNote += ` | Alamat: ${deliveryAddress}`;
                    }

                    if (extraNote.trim() !== '') {
                        finalNote += ` | Pesan: ${extraNote}`;
                    }
                    
                    document.getElementById('realNotes').value = finalNote;
                    
                    const btn = document.getElementById('btnSubmit');
                    btn.innerHTML = 'Memproses...';
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                    btn.disabled = true;
                    
                    form.submit();
                }
            </script>

        </div>
    </div>
</x-app-layout>