<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Code - BAWASLU Management Asset</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Arial, sans-serif; 
            margin: 20px; 
            background: #F9FAFB;
            color: #111827;
        }
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #B91C1C;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-title {
            margin: 0;
            font-size: 20px;
            color: #991B1B;
            font-weight: bold;
        }
        .header-subtitle {
            margin: 4px 0 0 0;
            font-size: 13px;
            color: #4B5563;
        }
        .btn-print {
            padding: 9px 18px; 
            background: #B91C1C; 
            color: white; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-print:hover {
            background: #991B1B;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .card {
            background: #FFFFFF;
            border: 1.5px dashed #CBD5E1;
            border-radius: 10px;
            padding: 14px 10px;
            text-align: center;
            page-break-inside: avoid;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .card svg { 
            width: 140px; 
            height: 140px; 
        }
        .kode { 
            font-weight: bold; 
            font-size: 13px; 
            margin-top: 8px;
            color: #B91C1C;
            letter-spacing: 0.5px;
        }
        .nama { 
            font-size: 12px; 
            color: #1F2937;
            margin-top: 2px;
            font-weight: 600;
        }
        .meta {
            font-size: 10px;
            color: #6B7280;
            margin-top: 4px;
            display: inline-block;
            background: #F3F4F6;
            padding: 2px 8px;
            border-radius: 4px;
        }
        @media print {
            body { background: white; margin: 0; }
            .no-print { display: none !important; }
            .grid { gap: 12px; }
            .card { 
                border: 1px solid #94A3B8; 
                box-shadow: none;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header-bar no-print">
        <div>
            <h1 class="header-title">🖨️ Lembar Cetak QR Code Aset BMN</h1>
            <p class="header-subtitle">Siap dipotong / ditempel pada unit barang fisik atau diproyeksikan langsung ke layar seminar.</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn-print">
                🖨️ Cetak / Simpan sebagai PDF (Ctrl + P)
            </button>
        </div>
    </div>

    <div class="grid">
        @foreach($items as $data)
            <div class="card">
                {!! $data['qr_svg'] !!}
                <div class="kode">{{ $data['item']->kode_bmn }}</div>
                <div class="nama">{{ $data['item']->nama_barang }}</div>
                <div class="meta">{{ $data['item']->kategori }} &bull; {{ $data['item']->lokasi_simpan }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>
