<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; }
        .header p { margin: 6px 0 0; color: #555; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ccc; padding: 8px; font-size: 12px; }
        .table th { background: #f4f4f4; text-align: left; }
        .summary { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .summary td { padding: 8px; border: 1px solid #ccc; font-size: 13px; }
        .section-title { font-size: 14px; margin: 16px 0 8px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan</h1>
        <p>Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
    </div>

    <table class="summary">
        <tr>
            <td><strong>Total Transaksi</strong></td>
            <td>{{ $totalTransactions }}</td>
        </tr>
        <tr>
            <td><strong>Total Omzet</strong></td>
            <td>Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Modal</strong></td>
            <td>Rp {{ number_format($totalModal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Laba Bersih</strong></td>
            <td>Rp {{ number_format($totalProfit, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="section-title">Ringkasan Kategori</div>
    <table class="table">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah Transaksi</th>
                <th>Omzet</th>
                <th>Laba</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryStats as $category => $stats)
            <tr>
                <td>{{ $categories[$category] ?? ucfirst($category) }}</td>
                <td>{{ $stats['count'] }}</td>
                <td>Rp {{ number_format($stats['omzet'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($stats['profit'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Top Produk Terlaris</div>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Terjual</th>
                <th>Omzet</th>
                <th>Laba</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $product)
            <tr>
                <td>{{ $product['name'] }}</td>
                <td>{{ $categories[$product['category']] ?? ucfirst($product['category']) }}</td>
                <td>{{ $product['count'] }}</td>
                <td>Rp {{ number_format($product['omzet'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($product['profit'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Detail Harian</div>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Transaksi</th>
                <th>Omzet</th>
                <th>Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyStats as $date => $stats)
            <tr>
                <td>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</td>
                <td>{{ $stats['count'] }}</td>
                <td>Rp {{ number_format($stats['omzet'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($stats['profit'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
