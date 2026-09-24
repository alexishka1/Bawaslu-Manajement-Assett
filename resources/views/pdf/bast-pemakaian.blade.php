<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BAST Pemakaian BMN - {{ $header->nomor_bast ?? 'DRAFT' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #1a1a1a;
            line-height: 1.5;
            padding: 35px 50px;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px double #1a1a1a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .kop-surat .instansi {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .kop-surat .sub-instansi {
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #b8860b;
        }
        .kop-surat .alamat {
            font-size: 8.5pt;
            color: #555;
            margin-top: 4px;
        }

        .judul-dokumen {
            text-align: center;
            margin: 15px 0 15px;
        }
        .judul-dokumen h2 {
            font-size: 13pt;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .judul-dokumen .nomor {
            font-size: 10.5pt;
            color: #333;
            margin-top: 3px;
            font-weight: bold;
        }

        .pembuka {
            margin-bottom: 12px;
            text-align: justify;
        }

        .pihak-box {
            margin-bottom: 10px;
        }
        .pihak-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
        }
        table.identitas-table {
            width: 100%;
            margin-bottom: 8px;
            font-size: 10.5pt;
        }
        table.identitas-table td {
            padding: 2px 4px;
            vertical-align: top;
        }
        table.identitas-table td.col-label {
            width: 25%;
        }
        table.identitas-table td.col-sep {
            width: 2%;
        }

        table.barang-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0 15px;
        }
        table.barang-table th,
        table.barang-table td {
            border: 1px solid #333;
            padding: 6px 8px;
            font-size: 10pt;
        }
        table.barang-table th {
            background-color: #f5f0e0;
            text-align: center;
            font-weight: bold;
        }

        .penutup {
            margin: 12px 0;
            text-align: justify;
        }

        .ttd-section {
            margin-top: 25px;
            width: 100%;
            page-break-inside: avoid;
        }
        .ttd-section table {
            width: 100%;
        }
        .ttd-section td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 5px;
        }
        .ttd-section .label {
            font-weight: bold;
            font-size: 10.5pt;
        }
        .ttd-section .space-ttd {
            height: 60px;
        }
        .ttd-section .space-ttd img {
            max-height: 60px;
            max-width: 150px;
        }
        .ttd-section .garis {
            border-bottom: 1px solid #1a1a1a;
            width: 190px;
            display: inline-block;
            margin-bottom: 4px;
        }
        .ttd-section .nama {
            font-weight: bold;
            font-size: 10.5pt;
        }
        .ttd-section .nip {
            font-size: 9.5pt;
            color: #444;
        }

        .verifikasi-box {
            margin-top: 15px;
            border: 1px dashed #9ca3af;
            background-color: #f9fafb;
            padding: 8px 12px;
            page-break-inside: avoid;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 50px;
            right: 50px;
            text-align: center;
            font-size: 7.5pt;
            color: #888;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="instansi">Badan Pengawas Pemilihan Umum</div>
        <div class="sub-instansi">BAWASLU</div>
        <div class="alamat">
            Jl. M.H. Thamrin No. 14, Jakarta Pusat 10350<br>
            Telp: (021) 31922450 | Fax: (021) 3192 2452 | Email: sekretariat@bawaslu.go.id
        </div>
    </div>

    <div class="judul-dokumen">
        <h2>
            @if($header->jenis_bast === 'BAST_PINJAM_PAKAI')
                BERITA ACARA PINJAM PAKAI BARANG MILIK NEGARA (BMN)
            @else
                BERITA ACARA SERAH TERIMA PEMAKAIAN BMN
            @endif
        </h2>
        <div class="nomor">Nomor: {{ $header->nomor_bast ?? 'DRAFT / BELUM DITERBITKAN' }}</div>
    </div>

    <div class="pembuka">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::parse($header->tanggal_bast)->translatedFormat('l') }}</strong> tanggal <strong>{{ \Carbon\Carbon::parse($header->tanggal_bast)->translatedFormat('d F Y') }}</strong> bertempat di <strong>{{ $header->lokasi }}</strong>, kami yang bertanda tangan di bawah ini:</p>
    </div>

    <div class="pihak-box">
        <div class="pihak-title">1. PIHAK PERTAMA (Yang Menyerahkan):</div>
        <table class="identitas-table">
            <tr>
                <td class="col-label">Nama</td>
                <td class="col-sep">:</td>
                <td><strong>{{ $header->pihakPertama->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td class="col-label">NIP</td>
                <td class="col-sep">:</td>
                <td>{{ $header->pihak_pertama_nip }}</td>
            </tr>
            <tr>
                <td class="col-label">Jabatan</td>
                <td class="col-sep">:</td>
                <td>{{ $header->pihakPertama->jabatan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="pihak-box">
        <div class="pihak-title">2. PIHAK KEDUA (Yang Menerima):</div>
        <table class="identitas-table">
            <tr>
                <td class="col-label">Nama</td>
                <td class="col-sep">:</td>
                <td><strong>{{ $header->pihak_kedua_tipe === 'internal' ? ($header->pihakKedua->nama ?? '-') : ($header->pihak_kedua_nama_manual ?? '-') }}</strong></td>
            </tr>
            @if($header->pihak_kedua_tipe === 'internal')
            <tr>
                <td class="col-label">NIP</td>
                <td class="col-sep">:</td>
                <td>{{ $header->pihak_kedua_nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-label">Jabatan / Unit Kerja</td>
                <td class="col-sep">:</td>
                <td>{{ $header->pihakKedua->jabatan ?? '-' }} / {{ $header->pihakKedua->unit_kerja ?? '-' }}</td>
            </tr>
            @else
            <tr>
                <td class="col-label">Kategori</td>
                <td class="col-sep">:</td>
                <td>Pihak Eksternal / Mitra Kerja</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="pembuka">
        <p>PIHAK PERTAMA telah menyerahkan Barang Milik Negara (BMN) kepada PIHAK KEDUA, dan PIHAK KEDUA telah menerima BMN tersebut dalam keadaan baik dan lengkap dengan rincian sebagai berikut:</p>
    </div>

    <table class="barang-table">
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 24%;">Kode BMN</th>
                <th style="width: 35%;">Nama / Deskripsi Barang</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 20%;">Kondisi Diserahkan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($header->details as $index => $detail)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="font-weight: bold;">{{ $detail->item->kode_bmn ?? '-' }}</td>
                <td>{{ $detail->item->nama_barang ?? '-' }}</td>
                <td style="text-align: center;">{{ $detail->item->kategori ?? '-' }}</td>
                <td style="text-align: center;">{{ $detail->kondisi_saat_diserahkan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #888;">Tidak ada rincian barang.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="penutup">
        <p>PIHAK KEDUA bertanggung jawab penuh atas pemeliharaan, keamanan, dan penggunaan BMN tersebut sesuai dengan ketentuan kedinasan yang berlaku di lingkungan Badan Pengawas Pemilihan Umum.</p>
    </div>

    <div class="ttd-section">
        <table>
            <tr>
                <td>
                    <div class="label">PIHAK KEDUA</div>
                    <div class="label">(Yang Menerima)</div>
                    <div class="space-ttd">
                        @if(!empty($ttdPihak2Base64))
                            <img src="{{ $ttdPihak2Base64 }}" alt="TTD Pihak 2">
                        @elseif($header->ttd_pihak2_url)
                            <img src="{{ $header->ttd_pihak2_url }}" alt="TTD Pihak 2">
                        @endif
                    </div>
                    <div class="garis"></div>
                    <div class="nama">{{ $header->pihak_kedua_tipe === 'internal' ? ($header->pihakKedua->nama ?? '-') : ($header->pihak_kedua_nama_manual ?? '-') }}</div>
                    <div class="nip">{{ $header->pihak_kedua_tipe === 'internal' ? 'NIP. ' . $header->pihak_kedua_nip : '' }}</div>
                </td>
                <td>
                    <div class="label">PIHAK PERTAMA</div>
                    <div class="label">(Yang Menyerahkan)</div>
                    <div class="space-ttd">
                        @if(!empty($ttdPihak1Base64))
                            <img src="{{ $ttdPihak1Base64 }}" alt="TTD Pihak 1">
                        @elseif($header->ttd_pihak1_url)
                            <img src="{{ $header->ttd_pihak1_url }}" alt="TTD Pihak 1">
                        @endif
                    </div>
                    <div class="garis"></div>
                    <div class="nama">{{ $header->pihakPertama->nama ?? '-' }}</div>
                    <div class="nip">NIP. {{ $header->pihak_pertama_nip }}</div>
                </td>
            </tr>
        </table>
    </div>

    @if(isset($qrCodeBase64))
    <div class="verifikasi-box">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 80px; text-align: center; vertical-align: middle;">
                    <img src="{{ $qrCodeBase64 }}" width="70" height="70" alt="QR Validasi">
                </td>
                <td style="vertical-align: middle; padding-left: 10px; font-size: 8pt; line-height: 1.35; color: #374151;">
                    <strong style="color: #111827; font-size: 8.5pt;">DOKUMEN DITANDATANGANI SECARA ELEKTRONIK (DIGITAL)</strong><br>
                    Dokumen BAST ini terdaftar sah dalam Sistem Informasi Manajemen Aset BMN Bawaslu.<br>
                    Pindai (scan) QR Code di samping untuk memeriksa integritas data atau kunjungi:<br>
                    <span style="color: #b91c1c; text-decoration: underline;">{{ $verifyUrl ?? url('/verify/bast-pemakaian/' . $header->id) }}</span>
                </td>
            </tr>
        </table>
    </div>
    @endif

    <div class="footer">
        Dokumen BAST Resmi — Dicetak otomatis oleh Sistem Manajemen Aset BMN Bawaslu pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

</body>
</html>