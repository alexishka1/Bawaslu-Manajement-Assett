<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAST - {{ $transaction->item->kode_bmn ?? 'N/A' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #1a1a1a;
            line-height: 1.6;
            padding: 40px 60px;
        }

        /* === HEADER / KOP SURAT === */
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #1a1a1a;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .kop-surat .instansi {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .kop-surat .sub-instansi {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #b8860b;
        }
        .kop-surat .alamat {
            font-size: 9pt;
            color: #555;
            margin-top: 5px;
        }

        /* === JUDUL DOKUMEN === */
        .judul-dokumen {
            text-align: center;
            margin: 25px 0 20px;
        }
        .judul-dokumen h2 {
            font-size: 14pt;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .judul-dokumen .nomor {
            font-size: 11pt;
            color: #444;
            margin-top: 5px;
        }

        /* === PARAGRAF PEMBUKA === */
        .pembuka {
            margin-bottom: 20px;
            text-align: justify;
        }

        /* === TABEL DATA === */
        .data-section {
            margin: 15px 0;
        }
        .data-section h3 {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
            border-left: 4px solid #b8860b;
            padding-left: 10px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th,
        table.data-table td {
            border: 1px solid #aaa;
            padding: 8px 12px;
            text-align: left;
            font-size: 11pt;
        }
        table.data-table th {
            background-color: #f5f0e0;
            font-weight: bold;
            width: 35%;
            color: #333;
        }
        table.data-table td {
            background-color: #fefefe;
        }

        /* === PARAGRAF PENUTUP === */
        .penutup {
            margin: 20px 0;
            text-align: justify;
        }

        /* === TANDA TANGAN === */
        .ttd-section {
            margin-top: 40px;
            width: 100%;
        }
        .ttd-section table {
            width: 100%;
        }
        .ttd-section td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        .ttd-section .label {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 5px;
        }
        .ttd-section .garis {
            margin-top: 80px;
            border-bottom: 1px solid #1a1a1a;
            width: 200px;
            display: inline-block;
        }
        .ttd-section .nama {
            font-weight: bold;
            font-size: 11pt;
            margin-top: 5px;
        }
        .ttd-section .jabatan {
            font-size: 10pt;
            color: #555;
        }

        /* === FOOTER === */
        .footer {
            position: fixed;
            bottom: 30px;
            left: 60px;
            right: 60px;
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <div class="instansi">Badan Pengawas Pemilihan Umum</div>
        <div class="sub-instansi">BAWASLU</div>
        <div class="alamat">
            Jl. M.H. Thamrin No. 14, Jakarta Pusat 10350<br>
            Telp: (021) 31922450 | Fax: (021) 3192 2452 | Email: sekretariat@bawaslu.go.id
        </div>
    </div>

    <!-- JUDUL DOKUMEN -->
    <div class="judul-dokumen">
        <h2>Berita Acara Serah Terima (BAST)</h2>
        <div class="nomor">Nomor: BAST/{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}/{{ \Carbon\Carbon::parse($transaction->tanggal_pinjam)->format('m/Y') }}</div>
    </div>

    <!-- PARAGRAF PEMBUKA -->
    <div class="pembuka">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::parse($transaction->tanggal_pinjam)->translatedFormat('l') }}</strong>,
        tanggal <strong>{{ \Carbon\Carbon::parse($transaction->tanggal_pinjam)->translatedFormat('d F Y') }}</strong>,
        telah dilaksanakan serah terima Barang Milik Negara (BMN) dengan rincian sebagai berikut:</p>
    </div>

    <!-- DATA BARANG -->
    <div class="data-section">
        <h3>Data Barang</h3>
        <table class="data-table">
            <tr>
                <th>Kode BMN</th>
                <td>{{ $transaction->item->kode_bmn ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <td>{{ $transaction->item->nama_barang ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $transaction->item->kategori ?? '-' }}</td>
            </tr>
            <tr>
                <th>Lokasi Penyimpanan</th>
                <td>{{ $transaction->item->lokasi_simpan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status Barang</th>
                <td>{{ ucfirst($transaction->item->status ?? '-') }}</td>
            </tr>
        </table>
    </div>

    <!-- DATA PEMINJAM -->
    <div class="data-section">
        <h3>Data Peminjam</h3>
        <table class="data-table">
            <tr>
                <th>Nama Peminjam</th>
                <td>{{ $transaction->nama_peminjam }}</td>
            </tr>
            <tr>
                <th>Divisi / Bagian</th>
                <td>{{ $transaction->divisi }}</td>
            </tr>
            <tr>
                <th>Tanggal Pinjam</th>
                <td>{{ \Carbon\Carbon::parse($transaction->tanggal_pinjam)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>Tanggal Kembali</th>
                <td>{{ $transaction->tanggal_kembali ? \Carbon\Carbon::parse($transaction->tanggal_kembali)->translatedFormat('d F Y') : 'Belum ditentukan' }}</td>
            </tr>
            @if($transaction->catatan)
            <tr>
                <th>Catatan</th>
                <td>{{ $transaction->catatan }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- PARAGRAF PENUTUP -->
    <div class="penutup">
        <p>Demikian Berita Acara Serah Terima ini dibuat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd-section">
        <table>
            <tr>
                <td>
                    <div class="label">Pihak Pertama</div>
                    <div class="label">(Yang Menyerahkan)</div>
                    <div class="garis"></div>
                    <div class="nama">Admin BMN</div>
                    <div class="jabatan">Koordinator Aset</div>
                </td>
                <td>
                    <div class="label">Pihak Kedua</div>
                    <div class="label">(Yang Menerima)</div>
                    <div class="garis"></div>
                    <div class="nama">{{ $transaction->nama_peminjam }}</div>
                    <div class="jabatan">{{ $transaction->divisi }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh Sistem Manajemen Inventaris BMN Bawaslu pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

</body>
</html>
