<x-app-layout>
    <div class="py-8 sm:py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Selesaikan Pembayaran Anda</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Pilih metode di bawah dan segera lakukan pembayaran</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                
                <div x-data="countdownTimer()" x-init="startTimer()" class="bg-red-500 p-4 text-center">
                    <p class="text-red-100 text-sm font-medium uppercase tracking-wider">Selesaikan Sebelum</p>
                    <div class="text-white text-3xl font-bold mt-1 tracking-widest" x-text="timeDisplay">
                        24:00:00
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <div class="text-center mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400 mb-2 font-medium">Total Tagihan</p>
                        <h1 class="text-5xl font-extrabold text-blue-600 dark:text-blue-400">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </h1>
                        <p class="text-sm text-gray-500 mt-3 font-mono bg-gray-100 dark:bg-gray-700 inline-block px-3 py-1 rounded-full">
                            Order ID: TRX-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>

                    <div x-data="{ 
                            tab: '{{ Str::contains($order->notes, 'QRIS') ? 'qris' : (Str::contains($order->notes, 'Transfer') ? 'va' : 'cod') }}',
                            copyToClipboard(text) {
                                navigator.clipboard.writeText(text);
                                alert('Berhasil disalin ke clipboard: ' + text);
                            }
                        }">
                        
                        <div class="flex p-1 bg-gray-100 dark:bg-gray-700 rounded-xl mb-8">
                            <button @click="tab = 'qris'" :class="{ 'bg-white dark:bg-gray-800 shadow-md text-blue-600 font-bold': tab === 'qris', 'text-gray-500 hover:text-gray-700': tab !== 'qris' }" class="flex-1 py-3 text-sm font-medium rounded-lg transition duration-200">
                                Scan QRIS
                            </button>
                            <button @click="tab = 'va'" :class="{ 'bg-white dark:bg-gray-800 shadow-md text-blue-600 font-bold': tab === 'va', 'text-gray-500 hover:text-gray-700': tab !== 'va' }" class="flex-1 py-3 text-sm font-medium rounded-lg transition duration-200">
                                Transfer Bank
                            </button>
                            <button @click="tab = 'cod'" :class="{ 'bg-white dark:bg-gray-800 shadow-md text-blue-600 font-bold': tab === 'cod', 'text-gray-500 hover:text-gray-700': tab !== 'cod' }" class="flex-1 py-3 text-sm font-medium rounded-lg transition duration-200">
                                Bayar di Konter
                            </button>
                        </div>

                        <div x-show="tab === 'qris'" x-transition.opacity class="text-center py-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-3xl inline-block border-2 border-blue-200 dark:border-blue-800 shadow-sm relative">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" class="h-8 mx-auto mb-4 bg-white px-2 py-1 rounded">
                                
                                <div class="bg-white p-3 rounded-2xl shadow-inner inline-block">
                                    <img src="{{ asset('img/qris-riocell.jpg') }}" alt="QR Code Pembayaran Asli" class="w-64 h-auto mx-auto rounded-lg border border-gray-100">
                                </div>
                                
                                <h3 class="font-extrabold text-gray-900 dark:text-white text-xl mt-4">Atas Nama Feny Cell</h3>
                            </div>
                            <div class="mt-8 flex justify-center items-center space-x-6">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" class="h-6 opacity-70 hover:opacity-100 transition" alt="Dana">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg" class="h-6 opacity-70 hover:opacity-100 transition" alt="OVO">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" class="h-6 opacity-70 hover:opacity-100 transition" alt="Gopay">
                                
                                <div class="flex items-center text-[#EE4D2D] opacity-70 hover:opacity-100 transition cursor-default select-none">
                                    <svg class="w-6 h-6 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.5 8V7A5.5 5.5 0 0112 1.5 5.5 5.5 0 0117.5 7v1H21a1 1 0 011 1v12a3 3 0 01-3 3H5a3 3 0 01-3-3V9a1 1 0 011-1h3.5zM12 3.5A3.5 3.5 0 008.5 7v1h7V7A3.5 3.5 0 0012 3.5zM8 12.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm8 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-[1.35rem] font-bold tracking-tighter" style="font-family: Arial, sans-serif;">Shopee<span class="font-medium">Pay</span></span>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-4 bg-gray-100 dark:bg-gray-800 py-2 px-4 rounded-lg inline-block">
                                Scan kode di atas dan bayarkan <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                            </p>
                        </div>

                        <div x-show="tab === 'va'" x-transition.opacity style="display: none;">
                            <div class="bg-amber-50 dark:bg-gray-800 border-l-4 border-amber-500 dark:border-amber-400 rounded-r-xl p-4 mb-6 shadow-sm">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-amber-500 dark:text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-amber-800 dark:text-amber-200 leading-snug">
                                            Pastikan nominal transfer <strong class="font-bold">sesuai hingga 3 digit terakhir</strong> untuk mempermudah pengecekan.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-5">
                                <div class="p-5 border-2 border-gray-200 dark:border-gray-700 rounded-2xl bg-white dark:bg-gray-800 hover:border-blue-500 transition shadow-sm relative overflow-hidden">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4 shadow-md">BCA</div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">Bank BCA</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Atas Nama: <strong class="text-gray-700 dark:text-gray-300">HILMAN / RIO CELL</strong></p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-end bg-gray-50 dark:bg-gray-900 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                        <div>
                                            <p class="text-xs text-gray-500 mb-1">Nomor Rekening</p>
                                            <p class="text-2xl font-mono font-bold text-blue-600 dark:text-blue-400 tracking-wider">8077083113188047</p>
                                        </div>
                                        <button @click="copyToClipboard('8077083113188047')" class="bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 px-4 py-2 rounded-lg font-bold text-sm transition flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            Salin
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'cod'" x-transition.opacity style="display: none;" class="text-center py-8">
                            <div class="w-24 h-24 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                                <span class="text-5xl">🏠</span>
                            </div>
                            <h3 class="font-extrabold text-gray-900 dark:text-white text-2xl">Bayar Langsung di Konter</h3>
                            <div class="mt-4 bg-gray-50 dark:bg-gray-800 p-5 rounded-2xl inline-block text-left border border-gray-200 dark:border-gray-700 shadow-sm max-w-sm">
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <span class="text-green-500 mr-2">1.</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Datang langsung ke konter Rio Cell.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-green-500 mr-2">2.</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Tunjukkan <strong>Order ID TRX-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong> kepada kasir.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-green-500 mr-2">3.</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Siapkan uang tunai sebesar <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-gray-50 dark:bg-gray-900 p-6 sm:p-8 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="https://wa.me/6283113188047?text=Halo%20Admin%20Rio%20Cell,%20saya%20sudah%20melakukan%20pembayaran%20untuk%20Order%20ID:%20TRX-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}%20sebesar%20Rp%20{{ number_format($order->total_price, 0, ',', '.') }}.%20Berikut%20saya%20lampirkan%20bukti%20transfernya:" 
                           target="_blank"
                           class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 flex justify-center items-center text-lg">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.305-.883-.653-1.48-1.459-1.653-1.756-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Kirim Bukti Pembayaran via WA
                        </a>
                        <a href="{{ route('pelanggan.orders') }}" class="flex-1 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-2 border-gray-300 dark:border-gray-600 text-center py-4 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition text-lg flex justify-center items-center">
                            Cek Status Pesanan
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function countdownTimer() {
            return {
                timeDisplay: '24:00:00',
                totalSeconds: 24 * 60 * 60, // 24 jam

                startTimer() {
                    setInterval(() => {
                        if (this.totalSeconds > 0) {
                            this.totalSeconds--;
                            let h = Math.floor(this.totalSeconds / 3600);
                            let m = Math.floor((this.totalSeconds % 3600) / 60);
                            let s = this.totalSeconds % 60;

                            this.timeDisplay = 
                                String(h).padStart(2, '0') + ':' + 
                                String(m).padStart(2, '0') + ':' + 
                                String(s).padStart(2, '0');
                        } else {
                            this.timeDisplay = 'KADALUARSA';
                        }
                    }, 1000);
                }
            }
        }
    </script>
</x-app-layout>