<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Struk #{{ $transaction->id }}</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            max-width: 80mm;
            margin: 20px auto;
            padding: 20px;
        }
        
        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .print-button button {
            padding: 10px 20px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button button:hover {
            background: #2563eb;
        }
    </style>
</head>
<body>
    <div class="no-print print-button">
        <button onclick="window.print()">🖨️ Print Struk</button>
        <button onclick="window.close()" style="background: #6b7280;">✖️ Tutup</button>
    </div>

    @include('owner.struk.template')

    <script>
        // Auto print ketika halaman dimuat (opsional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>