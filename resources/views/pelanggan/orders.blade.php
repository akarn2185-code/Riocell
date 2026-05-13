<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-xl text-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="flex overflow-x-auto gap-2 pb-2 mb-6 scrollbar-hide">
                <a href="{{ route('pelanggan.orders') }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Semua ({{ array_sum($statusCounts) }})
                </a>
                <a href="{{ route('pelanggan.orders', ['status' => 'pending']) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Pending ({{ $statusCounts['pending'] }})
                </a>
                <a href="{{ route('pelanggan.orders', ['status' => 'diproses']) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'diproses' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Diproses ({{ $statusCounts['diproses'] }})
                </a>
                <a href="{{ route('pelanggan.orders', ['status' => 'selesai']) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'selesai' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Selesai ({{ $statusCounts['selesai'] }})
                </a>
                <a href="{{ route('pelanggan.orders', ['status' => 'ditolak']) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'ditolak' ? 'bg-red-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Ditolak ({{ $statusCounts['ditolak'] }})
                </a>
            </div>

            @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden relative">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br 
                                    @if($order->product->category == 'pulsa') from-red-500 to-red-600
                                    @elseif($order->product->category == 'paket_data') from-blue-500 to-blue-600
                                    @elseif($order->product->category == 'e_wallet') from-green-500 to-green-600
                                    @else from-purple-500 to-purple-600
                                    @endif
                                    rounded-xl flex items-center justify-center">
                                    @if($order->product->category == 'pulsa')
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    @elseif($order->product->category == 'paket_data')
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                    </svg>
                                    @elseif($order->product->category == 'e_wallet')
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    @else
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    @endif
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">{{ $order->product->name }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $order->customer_phone }}</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full
                                @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($order->status == 'diproses') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($order->status == 'selesai') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="flex flex-wrap justify-between items-end gap-2 mt-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Total: <span class="font-semibold text-gray-900 dark:text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>

                            <div class="flex flex-col items-end gap-2">
                                @if($order->notes)
                                <p class="text-xs text-gray-500 dark:text-gray-400 italic mb-2">"{{ Str::limit($order->notes, 50) }}"</p>
                                @endif

                                <div class="flex items-center gap-2 mt-2">
                                    <a href="{{ route('pelanggan.order.receipt', $order) }}" target="_blank" class="px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-bold flex items-center gap-2 border border-gray-200 dark:border-gray-600 shadow-sm transition">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Struk
                                    </a>

                                    @if($order->status == 'pending')
                                    <a href="{{ route('pelanggan.order.payment', $order) }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg text-sm font-bold shadow-md transition transform active:scale-95 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Lanjut Pembayaran
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($order->status == 'ditolak' && $order->reject_reason)
                        <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg border border-red-100 dark:border-red-800">
                            <p class="text-xs text-red-700 dark:text-red-300">
                                <strong>Alasan Penolakan:</strong> {{ $order->reject_reason }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 sm:p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                <svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum ada pesanan</h3>
                <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-4">Yuk mulai belanja produk menarik di Rio Cell!</p>
                <a href="{{ route('pelanggan.catalog') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Lihat Katalog Produk
                </a>
            </div>
            @endif

        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>