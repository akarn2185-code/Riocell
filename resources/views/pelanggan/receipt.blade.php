<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Rio Cell - TRX-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 14px; color: #000; background: #f3f4f6; 
            margin: 0; padding: 20px; display: flex; justify-content: center; 
        }
        .receipt { 
            width: 300px; padding: 20px; background: #fff; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 12px 0; }
        .flex { display: flex; justify-content: space-between; }
        .text-sm { font-size: 12px; }
        
        /* Pengaturan Khusus Saat Dicetak / Disimpan ke PDF */
        @media print {
            @page {
                size: 80mm 140mm; 
                margin: 0mm;
            }
            body { padding: 5mm; background: #fff; }
            .receipt { box-shadow: none; width: 100%; padding: 0; margin: 0 auto; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="text-center font-bold" style="font-size: 18px;">RIO CELL</div>
        <div class="text-center text-sm">
            Jl. Soekarno-Hatta, Bandung<br>
            0831-1318-8047
        </div>

        <div class="divider"></div>

        <div class="text-sm">
            <div>Waktu : {{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div>Trx ID: TRX-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div>No. HP: {{ $order->customer_phone }}</div>
            <div>Status: {{ strtoupper($order->status) }}</div>
        </div>

        <div class="divider"></div>

        <div style="margin-bottom: 8px;">
            <div class="font-bold">{{ $order->product->name }}</div>
            <div class="flex text-sm">
                <span>1x</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <div class="flex font-bold" style="font-size: 16px;">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="divider"></div>
        
        <div class="text-center text-sm" style="margin-top: 15px;">
            <p>*** TERIMA KASIH ***</p>
            <p>Simpan struk ini sebagai<br>bukti transaksi yang sah.</p>
        </div>

        <div class="text-center mt-4 no-print" style="margin-top: 20px;">
            <button onclick="window.print()" style="padding: 10px; background: #2563eb; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%;">
                🖨️ Cetak / Simpan PDF
            </button>
            <p style="font-size: 11px; margin-top: 10px; color: #666;">
                *Pilih "Save as PDF" di menu printer untuk mengirim via WhatsApp.<br>
                *(Jangan lupa uncheck "Headers and footers" di pengaturan print agar lebih rapi)
            </p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        }
    </script>
</body>
</html>