<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>BAST Pengembalian BMN - {{ $header->nomor_bast_pengembalian ?? 'DRAFT' }}</title>
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
        <h2>BERITA ACARA SERAH TERIMA PENGEMBALIAN BMN</h2>
        <div class="nomor">Nomor: {{ $header->nomor_bast_pengembalian ?? 'DRAFT / BELUM DITERBITKAN' }}</div>
    </div>

    <div class="pembuka">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::parse($header->tanggal)->translatedFormat('l') }}</strong> tanggal <strong>{{ \Carbon\Carbon::parse($header->tanggal)->translatedFormat('d F Y') }}</strong> bertempat di <strong>{{ $header->lokasi }}</strong>, telah dilaksanakan serah terima pengembalian Barang Milik Negara (BMN) antara pihak-pihak berikut:</p>
    </div>

    <div class="pihak-box">
        <div class="pihak-title">1. PIHAK YANG MENYERAHKAN KEMBALI (Pengembali):</div>
        <table class="identitas-table">
            <tr>
                <td class="col-label">Nama</td>
                <td class="col-sep">:</td>
                <td><strong>{{ $header->pihak_menyerahkan_tipe === 'internal' ? ($header->pihakMenyerahkan->nama ?? '-') : ($header->pihak_menyerahkan_nama_manual ?? '-') }}</strong></td>
            </tr>
            @if($header->pihak_menyerahkan_tipe === 'internal')
            <tr>
                <td class="col-label">NIP</td>
                <td class="col-sep">:</td>
                <td>{{ $header->pihak_menyerahkan_nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-label">Jabatan / Unit Kerja</td>
                <td class="col-sep">:</td>
                <td>{{ $header->pihakMenyerahkan->jabatan ?? '-' }} / {{ $header->pihakMenyerahkan->unit_kerja ?? '-' }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="pihak-box">
        <div class="pihak-title">2. PIHAK YANG MENERIMA KEMBALI (Pejabat BMN):</div>
        <table class="identitas-table">
            <tr>
                <td class="col-label">Nama</td>
                <td class="col-sep">:</td>
                <td><strong>{{ $header->pihakMenerima->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td class="col-label">NIP</td>
                <td class="col-sep">:</td>
                <td>{{ $header->pihak_menerima_nip }}</td>
            </tr>
            <tr>
                <td class="col-label">Jabatan</td>
                <td class="col-sep">:</td>
                <td>{{ $header->pihakMenerima->jabatan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="pembuka">
        <p>Barang Milik Negara (BMN) yang diserahkan kembali telah dilakukan pengecekan fisik dengan rincian sebagai berikut:</p>
    </div>

    <table class="barang-table">
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 24%;">Kode BMN</th>
                <th style="width: 30%;">Nama Barang</th>
                <th style="width: 20%;">Kondisi Saat Kembali</th>
                <th style="width: 20%;">Catatan Kerusakan / Fisik</th>
            </tr>
        </thead>
        <tbody>
            @forelse($header->details as $index => $detail)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="font-weight: bold;">{{ $detail->item->kode_bmn ?? '-' }}</td>
                <td>{{ $detail->item->nama_barang ?? '-' }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $detail->kondisi_saat_kembali }}</td>
                <td>{{ $detail->catatan_kerusakan ?: 'Lengkap / Normal' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #888;">Tidak ada rincian barang dikembalikan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="penutup">
        <p>Demikian Berita Acara Serah Terima Pengembalian ini dibuat dengan sebenarnya dalam rangkap secukupnya untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd-section">
        <table>
            <tr>
                <td>
                    <div class="label">Yang Menyerahkan Kembali</div>
                    <div class="label">(Pengembali)</div>
                    <div class="space-ttd">
                        @if(!empty($ttdPihak1Base64))
                            <img src="{{ $ttdPihak1Base64 }}" alt="TTD Pengembali">
                        @elseif($header->ttd_pihak1_url)
                            <img src="{{ $header->ttd_pihak1_url }}" alt="TTD Pengembali">
                        @endif
                    </div>
                    <div class="garis"></div>
                    <div class="nama">{{ $header->pihak_menyerahkan_tipe === 'internal' ? ($header->pihakMenyerahkan->nama ?? '-') : ($header->pihak_menyerahkan_nama_manual ?? '-') }}</div>
                    <div class="nip">{{ $header->pihak_menyerahkan_tipe === 'internal' ? 'NIP. ' . $header->pihak_menyerahkan_nip : '' }}</div>
                </td>
                <td>
                    <div class="label">Yang Menerima Kembali</div>
                    <div class="label">(Pejabat BMN)</div>
                    <div class="space-ttd">
                        @if(!empty($ttdPihak2Base64))
                            <img src="{{ $ttdPihak2Base64 }}" alt="TTD Pejabat">
                        @elseif($header->ttd_pihak2_url)
                            <img src="{{ $header->ttd_pihak2_url }}" alt="TTD Pejabat">
                        @endif
                    </div>
                    <div class="garis"></div>
                    <div class="nama">{{ $header->pihakMenerima->nama ?? '-' }}</div>
                    <div class="nip">NIP. {{ $header->pihak_menerima_nip }}</div>
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
                    Dokumen Pengembalian BAST ini terdaftar sah dalam Sistem Informasi Manajemen Aset BMN Bawaslu.<br>
                    Pindai (scan) QR Code di samping untuk memeriksa integritas data atau kunjungi:<br>
                    <span style="color: #b91c1c; text-decoration: underline;">{{ $verifyUrl ?? url('/verify/bast-pengembalian/' . $header->id) }}</span>
                </td>
            </tr>
        </table>
    </div>
    @endif

    <div class="footer">
        Dokumen Pengembalian Resmi — Dicetak otomatis oleh Sistem Manajemen Aset BMN Bawaslu pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

</body>
</html>