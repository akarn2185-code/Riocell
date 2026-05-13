<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pesanan Online') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-xl text-sm">
                {{ session('success') }}
            </div>
            @endif

            <!-- Status Tabs -->
            <div class="flex overflow-x-auto gap-2 pb-2 mb-6 scrollbar-hide">
                <a href="{{ route('owner.orders.index') }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Semua ({{ array_sum($statusCounts) }})
                </a>
                <a href="{{ route('owner.orders.index', ['status' => 'pending']) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Pending ({{ $statusCounts['pending'] }})
                </a>
                <a href="{{ route('owner.orders.index', ['status' => 'diproses']) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'diproses' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Diproses ({{ $statusCounts['diproses'] }})
                </a>
                <a href="{{ route('owner.orders.index', ['status' => 'selesai']) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'selesai' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Selesai ({{ $statusCounts['selesai'] }})
                </a>
                <a href="{{ route('owner.orders.index', ['status' => 'ditolak']) }}" class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium {{ request('status') == 'ditolak' ? 'bg-red-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Ditolak ({{ $statusCounts['ditolak'] }})
                </a>
            </div>

            <!-- Orders List -->
            @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $order->product->name ?? 'Produk' }}</h3>
                                    <p class="text-sm text-gray-500">{{ $order->user->name ?? 'Guest' }} • {{ $order->customer_phone }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <p class="text-lg font-bold text-gray-900 dark:text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                <span class="mt-1 px-2.5 py-1 text-xs font-medium rounded-full
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'diproses') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'selesai') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        @if($order->notes)
                        <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Catatan:</strong> {{ $order->notes }}</p>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        @if($order->status == 'pending')
                        <div class="mt-4 flex flex-wrap gap-2">
                            <form action="{{ route('owner.orders.process', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                                    Proses
                                </button>
                            </form>
                            <button onclick="showRejectModal({{ $order->id }})" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200">
                                Tolak
                            </button>
                        </div>
                        @elseif($order->status == 'diproses')
                        <div class="mt-4">
                            <form action="{{ route('owner.orders.complete', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700">
                                    Selesaikan Pesanan
                                </button>
                            </form>
                        </div>
                        @endif

                        @if($order->status == 'ditolak' && $order->reject_reason)
                        <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                            <p class="text-sm text-red-700 dark:text-red-300"><strong>Alasan Penolakan:</strong> {{ $order->reject_reason }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500">Belum ada pesanan</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tolak Pesanan</h3>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan Penolakan</label>
                    <textarea name="reject_reason" required rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Masukkan alasan penolakan..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">Tolak Pesanan</button>
                    <button type="button" onclick="hideRejectModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRejectModal(orderId) {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectModal').classList.add('flex');
            document.getElementById('rejectForm').action = '/owner/orders/' + orderId + '/reject';
        }
        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectModal').classList.remove('flex');
        }
    </script>

    <style>.scrollbar-hide::-webkit-scrollbar { display: none; }</style>
</x-app-layout>