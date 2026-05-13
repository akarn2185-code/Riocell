<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi #{{ $transaction->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 10px;
            max-width: 80mm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .store-info {
            font-size: 10px;
            margin: 2px 0;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        
        .divider-bold {
            border-top: 2px solid #000;
            margin: 10px 0;
        }
        
        .transaction-info {
            margin-bottom: 10px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .product-section {
            margin: 10px 0;
        }
        
        .product-item {
            margin: 5px 0;
        }
        
        .product-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .product-details {
            font-size: 10px;
            margin-left: 5px;
        }
        
        .total-section {
            margin-top: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
        }
        
        .total-grand {
            font-size: 14px;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            border-top: 2px dashed #000;
            padding-top: 10px;
        }
        
        .footer-thank {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .barcode {
            text-align: center;
            margin: 10px 0;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">RC</div>
        <div class="store-name">RIO CELL</div>
        <div class="store-info">Pusat Pulsa & Aksesoris HP</div>
        <div class="store-info">Jl. Contoh No. 123, Kota</div>
        <div class="store-info">Telp: 081234567890</div>
    </div>

    <!-- Transaction Info -->
    <div class="transaction-info">
        <div class="info-row">
            <span class="info-label">No. Transaksi:</span>
            <span>#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kasir:</span>
            <span>Owner</span>
        </div>
        <div class="info-row">
            <span class="info-label">Customer:</span>
            <span>{{ $transaction->customer_phone }}</span>
        </div>
    </div>

    <div class="divider-bold"></div>

    <!-- Product Section -->
    <div class="product-section">
        <div class="product-item">
            <div class="product-name">{{ $transaction->product->name ?? 'Tukar Saldo' }}</div>
            <div class="product-details">
                <div class="info-row">
                    <span>Qty: {{ $transaction->quantity }}</span>
                    <span>@ Rp {{ number_format($transaction->sell_price / $transaction->quantity, 0, ',', '.') }}</span>
                </div>
                @if($transaction->notes)
                <div style="font-size: 9px; margin-top: 2px; font-style: italic;">
                    Catatan: {{ $transaction->notes }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Total Section -->
    <div class="total-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</span>
        </div>
        <div class="total-row total-grand">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($transaction->sell_price, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="divider-bold"></div>

    <!-- Payment Info -->
    <div style="text-align: center; font-size: 10px; margin: 10px 0;">
        <div style="margin-bottom: 3px;">Metode Pembayaran: <strong>{{ $transaction->transaction_type == 'pos' ? 'Tunai' : 'Online' }}</strong></div>
        <div>Tipe Transaksi: <strong>{{ strtoupper($transaction->transaction_type) }}</strong></div>
    </div>

    <!-- Barcode -->
    <div class="barcode">
        <div style="font-weight: bold; margin-bottom: 5px;">ID: TRX{{ str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}</div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-thank">TERIMA KASIH</div>
        <div>Telah berbelanja di Rio Cell</div>
        <div style="margin-top: 5px;">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</div>
        <div style="margin-top: 10px; font-size: 9px;">Dicetak: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>
</body>
</html>