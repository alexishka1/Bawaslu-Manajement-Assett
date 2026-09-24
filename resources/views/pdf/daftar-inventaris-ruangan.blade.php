<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Inventaris Ruangan (DIR) - {{ $ruangan->nama_ruangan }}</title>
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #111827;
            font-size: 8.5pt;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2.5px double #000;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .instansi {
            font-size: 13pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .judul-dokumen {
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 3px;
        }
        .nomor-kode {
            font-size: 8.5pt;
            color: #4b5563;
            margin-top: 2px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 12px;
            font-size: 8.5pt;
        }
        .meta-table td {
            padding: 2px 4px;
            vertical-align: top;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 8pt;
        }
        .data-table th {
            background-color: #f3f4f6;
            color: #111827;
            font-weight: bold;
            border: 1px solid #374151;
            padding: 5px 6px;
            text-align: center;
        }
        .data-table td {
            border: 1px solid #4b5563;
            padding: 4px 6px;
        }
        .text-center { text-align: center; }
        .ttd-table {
            width: 100%;
            margin-top: 15px;
            page-break-inside: avoid;
        }
        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 8.5pt;
        }
        .ttd-space {
            height: 55px;
        }
        .footer-note {
            margin-top: 10px;
            font-size: 7.5pt;
            color: #6b7280;
            border-top: 1px dotted #9ca3af;
            padding-top: 4px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="instansi">BADAN PENGAWAS PEMILIHAN UMUM</div>
        <div class="judul-dokumen">DAFTAR INVENTARIS RUANGAN (DIR)</div>
        <div class="nomor-kode">KODE RUANGAN: <strong>{{ $ruangan->kode_ruangan }}</strong> &bull; TAHUN ANGGARAN {{ date('Y') }}</div>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 20%;"><strong>Gedung / Kantor</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 38%;">{{ $ruangan->gedung ?? 'Kantor Bawaslu' }}</td>
            <td style="width: 20%;"><strong>Penanggung Jawab</strong></td>
            <td style="width: 2%;">:</td>
            <td>{{ $ruangan->penanggung_jawab ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Lantai</strong></td>
            <td>:</td>
            <td>{{ $ruangan->lantai ?? '-' }}</td>
            <td><strong>NIP / Identitas</strong></td>
            <td>:</td>
            <td>{{ $ruangan->nip_penanggung_jawab ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nama Ruangan</strong></td>
            <td>:</td>
            <td><strong>{{ $ruangan->nama_ruangan }}</strong></td>
            <td><strong>Tanggal Cetak</strong></td>
            <td>:</td>
            <td>{{ now()->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 20%;">KODE BMN</th>
                <th>NAMA BARANG / ASET</th>
                <th style="width: 15%;">KATEGORI</th>
                <th style="width: 12%;">KONDISI</th>
                <th style="width: 15%;">STATUS BMN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ruangan->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center" style="font-family: monospace; font-weight: bold;">{{ $item->kode_bmn }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td class="text-center">{{ $item->kategori }}</td>
                    <td class="text-center">
                        @if($item->status == 'tersedia') Baik
                        @elseif($item->status == 'terpakai') Baik (Aktif)
                        @elseif($item->status == 'servis') Perlu Servis
                        @elseif($item->status == 'rusak') Rusak
                        @else {{ ucfirst($item->status) }}
                        @endif
                    </td>
                    <td class="text-center">{{ strtoupper($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 12px; color: #6b7280; font-style: italic;">
                        Belum ada aset BMN yang tercatat ditempatkan di ruangan ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="font-weight: bold; text-align: right; padding-right: 10px;">TOTAL ASET DI RUANGAN:</td>
                <td colspan="2" class="text-center" style="font-weight: bold;">{{ $ruangan->items->count() }} Unit Barang</td>
            </tr>
        </tfoot>
    </table>

    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Pengelola / Pengurus Barang BMN</strong>
                <div class="ttd-space"></div>
                <strong>( .................................................... )</strong><br>
                NIP. .................................................
            </td>
            <td>
                {{ $ruangan->lokasi ?? 'Tempat' }}, {{ now()->translatedFormat('d F Y') }}<br>
                <strong>Penanggung Jawab Ruangan</strong>
                <div class="ttd-space"></div>
                <strong>( {{ $ruangan->penanggung_jawab ?: '....................................................' }} )</strong><br>
                NIP. {{ $ruangan->nip_penanggung_jawab ?: '.................................................' }}
            </td>
        </tr>
    </table>

    <div class="footer-note">
        * Lembar Daftar Inventaris Ruangan (DIR) ini wajib ditempel pada dinding / pintu ruangan terkait sesuai peraturan pengelolaan BMN instansi pemerintah.
    </div>

</body>
</html>
