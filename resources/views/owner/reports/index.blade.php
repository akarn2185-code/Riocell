<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Keuangan') }}
        </h2>
    </x-slot>

    <!-- Load Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filter Periode -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                <form method="GET" class="flex flex-col sm:flex-row gap-3 sm:items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition shadow-md hover:shadow-lg">
                            Filter Data
                        </button>
                        <a href="{{ route('owner.reports.index') }}" class="px-5 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition hover:bg-gray-300 dark:hover:bg-gray-600">
                            Reset
                        </a>
                    </div>
                </form>
                <p class="mt-3 text-sm text-gray-500">
                    Menampilkan data: <strong class="text-gray-700 dark:text-gray-300">{{ $startDate->format('d M Y') }}</strong> s/d <strong class="text-gray-700 dark:text-gray-300">{{ $endDate->format('d M Y') }}</strong>
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 justify-end mb-6">
                <a href="{{ route('owner.reports.print', request()->only(['start_date','end_date'])) }}" target="_blank"
                   class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                   Cetak Laporan
                </a>
                <a href="{{ route('owner.reports.download', request()->only(['start_date','end_date'])) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                   Download PDF
                </a>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-md transition">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-blue-100 dark:bg-blue-900/50 rounded-full">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Total Transaksi</p>
                            <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $totalTransactions }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-md transition">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-green-100 dark:bg-green-900/50 rounded-full">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Total Omzet</p>
                            <p class="text-base sm:text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-md transition">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-red-100 dark:bg-red-900/50 rounded-full">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Total Modal</p>
                            <p class="text-base sm:text-xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalModal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-white/20 rounded-full">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm text-green-100">Total Laba Bersih</p>
                            <p class="text-base sm:text-xl font-bold text-white">Rp {{ number_format($totalProfit, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GRAFIK GARIS (PENDAPATAN HARIAN) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center">
                        <span class="text-xl mr-2">📈</span> Tren Pendapatan Harian
                    </h3>
                </div>
                <div class="p-4 sm:p-6 relative h-72 sm:h-96 w-full">
                    @if($dailyStats->count() > 0)
                        <canvas id="salesChart"></canvas>
                    @else
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p>Belum ada data transaksi di periode ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BAGIAN GRAFIK PIE & LIST -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                <!-- KIRI: KATEGORI PRODUK -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <h3 class="font-bold text-gray-900 dark:text-white flex items-center">
                            <span class="text-xl mr-2">📊</span> Komposisi Kategori
                        </h3>
                    </div>
                    
                    <div class="p-4 sm:p-6">
                        @if($categoryStats->count() > 0)
                            <!-- Grafik Donut Kategori -->
                            <div class="relative h-48 w-full mb-6 flex justify-center">
                                <canvas id="categoryChart"></canvas>
                            </div>

                            <!-- List Detail Kategori -->
                            <div class="space-y-4">
                                @foreach($categoryStats as $category => $stats)
                                @php
                                    $percentage = $totalOmzet > 0 ? ($stats['omzet'] / $totalOmzet) * 100 : 0;
                                    // PERBAIKAN WARNA: MENAMBAHKAN WARNA ORANGE UNTUK TUKAR SALDO
                                    $colors = [
                                        'pulsa' => 'bg-red-500',
                                        'paket_data' => 'bg-blue-500',
                                        'e_wallet' => 'bg-green-500',
                                        'aksesoris' => 'bg-purple-500',
                                        'tukar_saldo' => 'bg-amber-500', // Warna Orange/Amber
                                    ];
                                @endphp
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $categories[$category] ?? ucfirst($category) }}</span>
                                        <span class="text-xs font-medium text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded">{{ number_format($percentage, 1) }}% ({{ $stats['count'] }} trx)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                        @php
                                            $barClass = ($colors[$category] ?? 'bg-gray-500') . ' h-2.5 rounded-full';
                                        @endphp
                                        <div class="{{ $barClass }}" data-width="{{ $percentage }}"></div>
                                    </div>
                                    <div class="flex justify-between mt-1">
                                        <span class="text-xs text-gray-500">Omzet: Rp {{ number_format($stats['omzet'], 0, ',', '.') }}</span>
                                        <span class="text-xs font-bold text-green-600">Laba: +Rp {{ number_format($stats['profit'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-8">Belum ada data</p>
                        @endif
                    </div>
                </div>

                <!-- KANAN: TOP 5 PRODUK TERLARIS -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden flex flex-col">
                    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                        <h3 class="font-bold text-gray-900 dark:text-white flex items-center">
                            <span class="text-xl mr-2">🏆</span> Top 5 Produk Terlaris
                        </h3>
                    </div>
                    
                    <div class="p-4 sm:p-6 flex-1 flex flex-col">
                        @if($topProducts->count() > 0)
                            <!-- Grafik Donut Produk -->
                            <div class="relative h-48 w-full mb-6 flex justify-center">
                                <canvas id="productChart"></canvas>
                            </div>

                            <!-- List Detail Produk Terlaris -->
                            <div class="divide-y divide-gray-100 dark:divide-gray-700 flex-1">
                                @forelse($topProducts as $product)
                                <div class="py-3 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 transition rounded-lg px-2">
                                    <div class="flex items-center">
                                        <span class="w-8 h-8 flex-shrink-0 {{ $loop->first ? 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-400 ring-2 ring-yellow-400' : 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' }} rounded-full flex items-center justify-center text-sm font-bold mr-3 shadow-sm">
                                            {{ $loop->iteration }}
                                        </span>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">{{ $product['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $product['count'] }}x Terjual • {{ $categories[$product['category']] ?? 'Lainnya' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right ml-2 flex-shrink-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Rp {{ number_format($product['omzet'], 0, ',', '.') }}</p>
                                        <p class="text-xs font-bold text-green-600">+Rp {{ number_format($product['profit'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="p-8 text-center text-gray-500">Belum ada data</div>
                                @endforelse
                            </div>
                        @else
                            <div class="flex-1 flex items-center justify-center">
                                <p class="text-gray-500">Belum ada data penjualan produk</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Daily Stats Table (Tabel Detail) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mt-6">
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="font-bold text-gray-900 dark:text-white">Tabel Detail Harian</h3>
                </div>
                @if($dailyStats->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Transaksi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Omzet</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Laba Bersih</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700/50">
                            @foreach($dailyStats->reverse() as $date => $stats)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <span class="bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 py-1 px-3 rounded-lg text-xs font-bold border border-blue-100 dark:border-blue-800">{{ $stats['count'] }} trx</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    Rp {{ number_format($stats['omzet'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400">
                                    +Rp {{ number_format($stats['profit'], 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 dark:bg-gray-900 border-t-2 border-gray-200 dark:border-gray-700">
                            <tr>
                                <td class="px-6 py-5 whitespace-nowrap text-sm font-black text-gray-900 dark:text-white uppercase">TOTAL PERIODE</td>
                                <td class="px-6 py-5 whitespace-nowrap text-base font-black text-gray-900 dark:text-white">{{ $totalTransactions }}</td>
                                <td class="px-6 py-5 whitespace-nowrap text-base font-black text-blue-600 dark:text-blue-400">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                                <td class="px-6 py-5 whitespace-nowrap text-base font-black text-green-600 dark:text-green-400">+Rp {{ number_format($totalProfit, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="p-8 text-center text-gray-500">
                    <p>Tidak ada rincian tabel untuk ditampilkan.</p>
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- SCRIPT DATA UNTUK CHART -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Apply widths from data attributes to progress bars
            document.querySelectorAll('[data-width]').forEach(el => {
                el.style.width = el.getAttribute('data-width') + '%';
            });
        });
    </script>

    <script type="application/json" id="chartDataDaily">
    {
        "labels": @json($chartDailyLabels),
        "omzet": @json($chartDailyOmzet),
        "profit": @json($chartDailyProfit)
    }
    </script>

    <script type="application/json" id="chartDataCategory">
    {
        "labels": @json($chartCategoryLabels),
        "omzet": @json($chartCategoryOmzet),
        "colors": @json($chartCategoryColors)
    }
    </script>

    <script type="application/json" id="chartDataProduct">
    {
        "labels": @json($chartProductLabels),
        "counts": @json($chartProductCounts)
    }
    </script>

    <!-- SCRIPT UNTUK MERENDER SEMUA GRAFIK -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            window.reportTheme = {
                textColor: isDarkMode ? '#e5e7eb' : '#374151',
                gridColor: isDarkMode ? '#374151' : '#f3f4f6',
                pieBorders: isDarkMode ? '#1f2937' : '#ffffff'
            };
        });
    </script>

    @if($dailyStats->count() > 0)
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const theme = window.reportTheme;
            const ctxLine = document.getElementById('salesChart');
            if (!ctxLine) return;
            
            const chartData = JSON.parse(document.getElementById('chartDataDaily').textContent);
            
            new Chart(ctxLine.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: 'Omzet (Rp)',
                            data: chartData.omzet,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#3b82f6',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Laba Bersih (Rp)',
                            data: chartData.profit,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#10b981',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { labels: { color: theme.textColor, font: { family: "'Figtree', sans-serif", weight: 'bold' } } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { color: theme.gridColor }, ticks: { color: theme.textColor } },
                        y: {
                            grid: { color: theme.gridColor },
                            ticks: {
                                color: theme.textColor,
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                    if (value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                                    return 'Rp ' + value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endif

    @if($categoryStats->count() > 0)
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const theme = window.reportTheme;
            const ctxCategory = document.getElementById('categoryChart');
            if (!ctxCategory) return;
            
            const chartData = JSON.parse(document.getElementById('chartDataCategory').textContent);
            
            new Chart(ctxCategory.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        data: chartData.omzet,
                        backgroundColor: chartData.colors,
                        borderColor: theme.pieBorders,
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'right', labels: { color: theme.textColor, font: { family: "'Figtree', sans-serif", size: 11 } } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endif

    @if($topProducts->count() > 0)
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const theme = window.reportTheme;
            const ctxProduct = document.getElementById('productChart');
            if (!ctxProduct) return;
            
            const chartData = JSON.parse(document.getElementById('chartDataProduct').textContent);
            
            new Chart(ctxProduct.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        data: chartData.counts,
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', '#ef4444'],
                        borderColor: theme.pieBorders,
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Terjual: ' + context.parsed + ' kali';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>