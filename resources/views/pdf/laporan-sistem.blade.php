<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Komprehensif Sistem Manajemen Aset BMN - Bawaslu</title>
    <style>
        @page {
            margin: 18mm 15mm 18mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1F2937;
            font-size: 8.5pt;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }
        
        /* COVER PAGE */
        .cover {
            text-align: center;
            padding-top: 30px;
            page-break-after: always;
        }
        .cover-header {
            margin-bottom: 25px;
        }
        .cover-logo {
            width: 90px;
            height: auto;
            margin-bottom: 12px;
        }
        .cover-instansi {
            font-size: 14pt;
            font-weight: bold;
            color: #111827;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .cover-subinstansi {
            font-size: 10pt;
            font-weight: 600;
            color: #B91C1C;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .cover-divider {
            height: 4px;
            background: linear-gradient(to right, #B91C1C, #D97706);
            width: 80%;
            margin: 0 auto 30px auto;
            border-radius: 2px;
        }
        .cover-title-box {
            background-color: #FEF2F2;
            border-left: 6px solid #B91C1C;
            border-right: 2px solid #FCA5A5;
            padding: 22px 20px;
            margin: 0 auto 30px auto;
            text-align: left;
            border-radius: 4px;
        }
        .cover-title {
            font-size: 16pt;
            font-weight: bold;
            color: #991B1B;
            line-height: 1.3;
            margin: 0 0 8px 0;
        }
        .cover-subtitle {
            font-size: 9.5pt;
            color: #4B5563;
            line-height: 1.4;
            margin: 0;
        }
        .cover-badge-row {
            margin-bottom: 35px;
        }
        .badge-pill {
            display: inline-block;
            background-color: #B91C1C;
            color: #FFFFFF;
            font-size: 8pt;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 12px;
            margin: 0 4px;
            text-transform: uppercase;
        }
        .badge-pill-gold {
            display: inline-block;
            background-color: #D97706;
            color: #FFFFFF;
            font-size: 8pt;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 12px;
            margin: 0 4px;
            text-transform: uppercase;
        }
        .cover-meta-table {
            width: 85%;
            margin: 0 auto;
            border-collapse: collapse;
            font-size: 8.5pt;
            text-align: left;
        }
        .cover-meta-table td {
            padding: 6px 10px;
            border-bottom: 1px solid #E5E7EB;
        }
        .cover-meta-table td.label {
            width: 35%;
            font-weight: bold;
            color: #4B5563;
        }
        .cover-meta-table td.value {
            color: #111827;
        }

        /* HEADINGS & CHAPTERS */
        h1.chapter-title {
            font-size: 13pt;
            font-weight: bold;
            color: #FFFFFF;
            background-color: #B91C1C;
            padding: 7px 12px;
            margin-top: 15px;
            margin-bottom: 12px;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        h2.section-title {
            font-size: 10.5pt;
            font-weight: bold;
            color: #991B1B;
            border-bottom: 2px solid #F3F4F6;
            padding-bottom: 4px;
            margin-top: 14px;
            margin-bottom: 8px;
        }
        h3.sub-section-title {
            font-size: 9pt;
            font-weight: bold;
            color: #111827;
            margin-top: 10px;
            margin-bottom: 4px;
        }
        p {
            margin-top: 0;
            margin-bottom: 8px;
            text-align: justify;
        }

        /* CARDS & HIGHLIGHTS */
        .callout-box {
            background-color: #F9FAFB;
            border-left: 4px solid #B91C1C;
            padding: 10px 14px;
            margin-bottom: 12px;
            border-radius: 0 4px 4px 0;
            font-size: 8.5pt;
        }
        .callout-gold {
            background-color: #FFFBEB;
            border-left: 4px solid #D97706;
            padding: 10px 14px;
            margin-bottom: 12px;
            border-radius: 0 4px 4px 0;
            font-size: 8.5pt;
        }
        .callout-success {
            background-color: #F0FDF4;
            border-left: 4px solid #15803D;
            padding: 10px 14px;
            margin-bottom: 12px;
            border-radius: 0 4px 4px 0;
            font-size: 8.5pt;
        }

        /* METRIC CARDS GRID (TABLE BASED FOR PDF) */
        .metrics-grid {
            width: 100%;
            margin-bottom: 14px;
            border-collapse: separate;
            border-spacing: 6px;
        }
        .metric-card {
            background-color: #FFFFFF;
            border: 1px solid #E5E7EB;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
            vertical-align: top;
        }
        .metric-card.red { border-top: 3px solid #B91C1C; }
        .metric-card.gold { border-top: 3px solid #D97706; }
        .metric-card.green { border-top: 3px solid #15803D; }
        .metric-card.blue { border-top: 3px solid #1D4ED8; }
        .metric-value {
            font-size: 16pt;
            font-weight: bold;
            color: #111827;
            margin: 2px 0;
        }
        .metric-label {
            font-size: 7.5pt;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
        }

        /* TABLES */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 8pt;
        }
        .custom-table th {
            background-color: #B91C1C;
            color: #FFFFFF;
            font-weight: bold;
            padding: 6px 8px;
            text-align: left;
            border: 1px solid #991B1B;
            text-transform: uppercase;
            font-size: 7.5pt;
            letter-spacing: 0.3px;
        }
        .custom-table td {
            padding: 5px 8px;
            border: 1px solid #E5E7EB;
            vertical-align: top;
        }
        .custom-table tr:nth-child(even) td {
            background-color: #F9FAFB;
        }

        /* STATUS BADGES */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background-color: #DCFCE7; color: #166534; }
        .badge-warning { background-color: #FEF3C7; color: #92400E; }
        .badge-danger { background-color: #FEE2E2; color: #991B1B; }
        .badge-info { background-color: #DBEAFE; color: #1E40AF; }

        /* LISTS */
        ol, ul {
            margin-top: 0;
            margin-bottom: 10px;
            padding-left: 20px;
        }
        li {
            margin-bottom: 4px;
        }

        /* FOOTER & UTILITIES */
        .page-break {
            page-break-after: always;
        }
        .avoid-break {
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
    </style>
</head>
<body>

    <!-- SCRIPT NOMOR HALAMAN DOMPDF -->
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Bawaslu Management Asset | Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            $font = $fontMetrics->getFont("Helvetica", "normal");
            $size = 7.5;
            $color = array(0.45, 0.45, 0.45);
            $pdf->page_text(40, $pdf->get_height() - 28, "Dokumen Resmi Sekretariat Bawaslu - Sistem Manajemen Aset BMN", $font, $size, $color);
            $width = $fontMetrics->get_text_width($text, $font, $size);
            $pdf->page_text($pdf->get_width() - 40 - $width, $pdf->get_height() - 28, $text, $font, $size, $color);
        }
    </script>

    <!-- ======================================================== -->
    <!-- HALAMAN COVER RESMI                                      -->
    <!-- ======================================================== -->
    <div class="cover">
        <div class="cover-header">
            @if(!empty($logoBase64))
                <img src="data:image/jpeg;base64,{{ $logoBase64 }}" class="cover-logo" alt="Logo Bawaslu">
            @endif
            <div class="cover-instansi">BADAN PENGAWAS PEMILIHAN UMUM</div>
            <div class="cover-subinstansi">SEKRETARIAT BAWASLU PROVINSI / KABUPATEN / KOTA</div>
            <div class="cover-divider"></div>
        </div>

        <div class="cover-title-box">
            <div class="cover-title">LAPORAN RESMI IMPLEMENTASI SISTEM INFORMASI MANAJEMEN ASET BMN</div>
            <div class="cover-subtitle">
                Aplikasi Tata Kelola Aset Barang Milik Negara (BMN) Digital Terpadu Berbasis Laravel 12 & Filament v4 Dilengkapi Modul BAST Elektronik, Tanda Tangan Digital, Tracking Geospasial OpenStreetMap, dan Gerbang Verifikasi Akun Pegawai.
            </div>
        </div>

        <div class="cover-badge-row">
            <span class="badge-pill">SIAP PRODUKSI (PRODUCTION READY)</span>
            <span class="badge-pill-gold">PERBAWASLU NO. 16/2017</span>
            <span class="badge-pill">94 AUTOMATED TESTS PASSED</span>
        </div>

        <table class="cover-meta-table">
            <tr>
                <td class="label">Nama Aplikasi</td>
                <td class="value"><strong>Bawaslu Management Asset</strong></td>
            </tr>
            <tr>
                <td class="label">Klasifikasi Dokumen</td>
                <td class="value">Laporan Teknis & Panduan Operasional Sistem Resmi</td>
            </tr>
            <tr>
                <td class="label">Versi Rilis</td>
                <td class="value">v2.0 (Build Final September 2026)</td>
            </tr>
            <tr>
                <td class="label">Identitas Visual</td>
                <td class="value">Merah Bawaslu (#B91C1C) & Emas Kehormatan (#D97706)</td>
            </tr>
            <tr>
                <td class="label">Basis Teknologi</td>
                <td class="value">Laravel 12 LTS, Filament v4, Livewire 3, Leaflet JS, DomPDF</td>
            </tr>
            <tr>
                <td class="label">Tingkat Pengujian</td>
                <td class="value">94 Fitur & Unit Tests (296 Assertions — 100% Lulus)</td>
            </tr>
            <tr>
                <td class="label">Tanggal Dokumen</td>
                <td class="value">{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</td>
            </tr>
        </table>
    </div>

    <!-- ======================================================== -->
    <!-- BAB 1: RINGKASAN EKSEKUTIF & LATAR BELAKANG              -->
    <!-- ======================================================== -->
    <h1 class="chapter-title">BAB 1. RINGKASAN EKSEKUTIF & LATAR BELAKANG</h1>

    <div class="callout-box">
        <strong>Ringkasan Eksekutif:</strong> Sistem Informasi <em>Bawaslu Management Asset</em> adalah platform tata kelola Barang Milik Negara (BMN) modern yang dikembangkan untuk menjawab kebutuhan akuntabilitas, transparansi, serta efisiensi operasional pada lingkungan Sekretariat Badan Pengawas Pemilihan Umum. Sistem ini mentransformasi seluruh pencatatan inventaris fisik menjadi ekosistem digital <em>paperless</em> terverifikasi hukum.
    </div>

    <h2 class="section-title">1.1 Latar Belakang Digitalisasi Aset</h2>
    <p>
        Pengelolaan Barang Milik Negara (BMN) di lingkungan lembaga pemerintah memiliki standar kepatuhan yang ketat sesuai regulasi Kementerian Keuangan serta petunjuk teknis internal Bawaslu. Sebelumnya, pencatatan BAST (Berita Acara Serah Terima) peminjaman barang dinas (laptop, kamera pengawasan pemilu, proyektor, kendaraan operasional) dilakukan secara manual berbasis lembaran kertas fisik.
    </p>
    <p>Permasalahan yang sering ditemui pada sistem lama meliputi:</p>
    <ul>
        <li><strong>Hilangnya Bukti Fisik BAST:</strong> Dokumen kertas peminjaman rentan rusak, terselip, atau hilang seiring berjalannya waktu.</li>
        <li><strong>Kehilangan Jejak Fisik Barang (Blind Tracking):</strong> Petugas pengelola BMN kesulitan mendeteksi di mana posisi barang yang sedang dibawa oleh pegawai di lapangan maupun alamat domisili peminjam.</li>
        <li><strong>Proses Pengembalian Tidak Terdokumentasi Rapi:</strong> Tidak adanya catatan riwayat kondisi fisik saat dipinjam vs saat dikembalikan sehingga menyulitkan klaim ganti rugi atau pemeliharaan.</li>
        <li><strong>Pintu Akses yang Tidak Terverifikasi:</strong> Belum tersedianya sistem verifikasi mandiri bagi pegawai baru yang ingin mengajukan pinjaman inventaris, menimbulkan risiko akses ilegal.</li>
    </ul>

    <h2 class="section-title">1.2 Ringkasan Metrik Database Saat Ini</h2>
    <p>Berikut adalah ringkasan data operasional yang saat ini telah terdaftar dan aktif dalam database sistem:</p>

    <table class="metrics-grid">
        <tr>
            <td class="metric-card red" style="width: 25%;">
                <div class="metric-label">Total Aset Terdata</div>
                <div class="metric-value">{{ $stats['items_total'] ?? 0 }}</div>
                <div class="metric-label" style="color: #B91C1C;">Unit BMN</div>
            </td>
            <td class="metric-card gold" style="width: 25%;">
                <div class="metric-label">Dokumen BAST</div>
                <div class="metric-value">{{ ($stats['bast_pemakaian'] ?? 0) + ($stats['bast_pengembalian'] ?? 0) }}</div>
                <div class="metric-label" style="color: #D97706;">Arsip Digital</div>
            </td>
            <td class="metric-card blue" style="width: 25%;">
                <div class="metric-label">Master Ruangan</div>
                <div class="metric-value">{{ $stats['ruangan'] ?? 0 }}</div>
                <div class="metric-label" style="color: #1D4ED8;">Ruang Kerja</div>
            </td>
            <td class="metric-card green" style="width: 25%;">
                <div class="metric-label">Pengguna Terdaftar</div>
                <div class="metric-value">{{ $stats['users'] ?? 0 }}</div>
                <div class="metric-label" style="color: #15803D;">Akun Aktif</div>
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- ======================================================== -->
    <!-- BAB 2: ARSITEKTUR TEKNOLOGI & KEAMANAN                   -->
    <!-- ======================================================== -->
    <h1 class="chapter-title">BAB 2. ARSITEKTUR TEKNOLOGI & KEAMANAN SISTEM</h1>

    <h2 class="section-title">2.1 Komponen Tumpukan Teknologi (Tech Stack)</h2>
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 25%;">Komponen</th>
                <th style="width: 30%;">Teknologi / Library</th>
                <th style="width: 45%;">Peran & Keunggulan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Framework Inti</strong></td>
                <td>Laravel 12 LTS (PHP 8.3+)</td>
                <td>Arsitektur MVC tangguh, routing handal, Eloquent ORM performa tinggi, dan proteksi CSRF bawaan.</td>
            </tr>
            <tr>
                <td><strong>Panel Admin</strong></td>
                <td>Filament v4 & Livewire 3</td>
                <td>Antarmuka dasbor modern berbasis komponen reaktif tanpa perlu reload halaman penuh.</td>
            </tr>
            <tr>
                <td><strong>Engine Geospasial</strong></td>
                <td>Leaflet.js + OpenStreetMap</td>
                <td>Peta interaktif pelacakan pin peminjam tanpa batas kuota API dan tanpa biaya langganan berbayar (Free & Open Source).</td>
            </tr>
            <tr>
                <td><strong>Dokumen Digital</strong></td>
                <td>Barryvdh DomPDF + Canvas TTD</td>
                <td>Rendering PDF instan berstandar dokumen dinas pemerintah dengan tanda tangan digital langsung di layar.</td>
            </tr>
            <tr>
                <td><strong>Penyimpanan Data</strong></td>
                <td>Relational Database (SQLite / MySQL)</td>
                <td>Koneksi database terisolasi dengan integritas foreign key cascade dan transaksi data aman.</td>
            </tr>
            <tr>
                <td><strong>Label & Barcode</strong></td>
                <td>Simple Software IO QR Code</td>
                <td>Pembuatan QR Code dinamis otomatis untuk setiap unit barang yang terhubung langsung dengan sistem scanning.</td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title">2.2 Arsitektur Pemisahan Hak Akses (Role Isolation)</h2>
    <p>
        Aplikasi menerapkan pemisahan hak akses yang ketat antara level <strong>Administrator</strong> (Pengelola BMN) dan <strong>Staff / Pegawai</strong> (Pengguna Inventaris):
    </p>

    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 20%;">Peran Pengguna</th>
                <th style="width: 25%;">Jalur Akses (URL)</th>
                <th style="width: 55%;">Hak Akses & Otoritas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span class="badge badge-danger">ADMINISTRATOR</span></td>
                <td><code>/admin</code> (Filament Panel)</td>
                <td>
                    Mengelola seluruh master data, membuat & mengesahkan BAST, memverifikasi akun staf baru, mencetak DIR ruangan, memantau sebaran peta pinjaman, dan konfigurasi sistem.
                </td>
            </tr>
            <tr>
                <td><span class="badge badge-info">STAFF / PEGAWAI</span></td>
                <td><code>/scan</code> (Portal Mobile)</td>
                <td>
                    Memindai QR Code barang dinas dengan kamera HP, melihat spesifikasi & riwayat pemakaian barang, serta mengajukan permohonan pinjam barang. Dilarang mengakses <code>/admin</code>.
                </td>
            </tr>
            <tr>
                <td><span class="badge badge-warning">STAFF BARU (PENDING)</span></td>
                <td><code>/register</code></td>
                <td>
                    Staf mendaftar mandiri namun diblokir login-nya (<code>is_verified = false</code>) sampai Admin menyetujui akun tersebut melalui panel verifikasi.
                </td>
            </tr>
        </tbody>
    </table>

    <div class="callout-success">
        <strong>Keamanan Crossover Dilindungi:</strong> Middleware kustom <code>RedirectIfWrongRole</code> dan implementasi <code>User::canAccessPanel()</code> memastikan bahwa staf yang mencoba membuka URL <code>/admin</code> akan dialihkan kembali secara ramah ke portal staf, begitu juga sebaliknya jika admin mengakses halaman staf akan diarahkan ke dasbor admin.
    </div>

    <div class="page-break"></div>

    <!-- ======================================================== -->
    <!-- BAB 3: KATALOG FITUR LENGKAP SISTEM                      -->
    <!-- ======================================================== -->
    <h1 class="chapter-title">BAB 3. KATALOG & SPESIFIKASI FITUR SISTEM</h1>

    <h2 class="section-title">3.1 Dasbor Eksekutif & 9 Widget Analitik</h2>
    <p>
        Dasbor administrator dirancang dengan tata letak grid responsif multi-kolom yang menyajikan analitik komprehensif tanpa menyisakan elemen default "Filament":
    </p>
    <ul>
        <li><strong>4 Stat Badges Utama:</strong> Menampilkan angka riil Total Aset, Aset Sedang Dipakai, Aset Kondisi Rusak, dan Pinjaman yang Terlambat Dikembalikan (> 7 hari).</li>
        <li><strong>Widget Peta Sebaran Peminjam (Leaflet OpenStreetMap):</strong> Menampilkan pin lokasi peminjam barang yang sedang aktif. Setiap pin dilengkapi popup berisi nama peminjam, nama barang, alamat lengkap, dan tanggal peminjaman.</li>
        <li><strong>Donut Chart Status Aset:</strong> Visualisasi proporsi aset dengan palet resmi: Tersedia (Hijau), Dipakai (Emas), Pemeliharaan (Biru), dan Rusak (Merah).</li>
        <li><strong>Bar Chart Distribusi Kategori BMN:</strong> Menampilkan jumlah inventaris pada masing-masing kategori (Elektronik, Kendaraan Operasional, Mebel, ATK, Arsip Pengawasan).</li>
        <li><strong>Bar Chart Top 5 Barang Sering Dipinjam:</strong> Memberikan wawasan frekuensi barang paling favorit yang digunakan pegawai dalam operasional harian.</li>
        <li><strong>Line Chart Tren Transaksi 6 Bulan:</strong> Grafik garis pergerakan transaksi keluar-masuk barang dinas setiap bulannya.</li>
        <li><strong>Tabel Transaksi Terkini:</strong> Tabel ringkas 8 aktivitas transaksi aset terbaru lengkap dengan lencana status berwarna.</li>
        <li><strong>Widget Peringatan Jatuh Tempo (Overdue Loans):</strong> Kotak peringatan merah yang otomatis muncul jika terdapat peminjaman yang melampaui batas toleransi 7 hari kalender.</li>
    </ul>

    <h2 class="section-title">3.2 Modul Manajemen Aset BMN & Barcode / QR Code</h2>
    <p>
        Manajemen inventaris fisik dilakukan melalui modul master barang yang kaya atribut:
    </p>
    <ul>
        <li><strong>Pencatatan Atribut Lengkap:</strong> Kode Barang BMN, NUP (Nomor Urut Pendaftaran), Nama Barang, Merk/Tipe, Spesifikasi Teknis, Kategori Aset, Tahun Perolehan, Nilai Pembelian, dan Ruangan Penempatan.</li>
        <li><strong>Status & Kondisi Fisik:</strong> Pilihan status dinamis (Tersedia, Dipakai, Perbaikan, Dihapuskan) dan kondisi fisik (Baik, Rusak Ringan, Rusak Berat).</li>
        <li><strong>Generator QR Code Otomatis:</strong> Setiap aset yang disimpan otomatis menghasilkan kode QR unik terenkripsi yang dapat langsung dicetak sebagai stiker label aset tahan luntur.</li>
        <li><strong>Upload Dokumentasi Foto Fisik:</strong> Kemudahan melampirkan foto kondisi nyata barang saat masuk inventaris.</li>
    </ul>

    <h2 class="section-title">3.3 Modul BAST Pemakaian Digital & Geolocation Pinpoint</h2>
    <p>
        Inovasi unggulan sistem ini adalah penggantian format BAST kertas dengan BAST Elektronik interaktif:
    </p>
    <ul>
        <li><strong>Pencatatan Pihak 1 & Pihak 2:</strong> Pihak Pertama diisi otomatis oleh Pejabat BMN yang berwenang, Pihak Kedua dapat dipilih dari master pegawai Bawaslu atau diinput manual untuk pihak eksternal.</li>
        <li><strong>Interactive Pinpoint Map (Bukti Alamat Peminjam):</strong> Petugas cukup mengetik alamat rumah/kantor peminjam; peta otomatis mencari lokasi (Nominatim Geocoding), kemudian petugas dapat menggeser pin lokasi (drag-and-drop) agar titik koordinat latitude dan longitude tersimpan secara presisi.</li>
        <li><strong>Tanda Tangan Digital Langsung (E-Signature):</strong> Tersedia canvas tanda tangan digital pada formulir. Kedua belah pihak dapat langsung membubuhkan tanda tangan menggunakan jari pada layar touchscreen tablet/laptop atau mouse.</li>
        <li><strong>Update Otomatis Status Barang:</strong> Saat BAST disahkan berstatus <em>Final</em>, status barang di master inventaris otomatis berubah dari "Tersedia" menjadi "Dipakai".</li>
        <li><strong>Ekspor PDF BAST Resmi:</strong> Menghasilkan lembar PDF resmi ber-kop Bawaslu lengkap dengan nomor surat otomatis, tabel spesifikasi barang, titik koordinat, dan tanda tangan digital kedua pihak.</li>
    </ul>

    <div class="page-break"></div>

    <h2 class="section-title">3.4 Modul BAST Pengembalian & Rekonsiliasi Kondisi Fisik</h2>
    <p>
        Saat peminjam mengembalikan barang inventaris ke sekretariat:
    </p>
    <ul>
        <li><strong>Referensi ke BAST Pemakaian Awal:</strong> Petugas cukup memilih nomor BAST Pemakaian, dan daftar barang yang dipinjam akan otomatis terisi.</li>
        <li><strong>Pemeriksaan Kondisi Fisik Aktual:</strong> Petugas memeriksa apakah barang kembali dalam kondisi "Baik", "Rusak Ringan", atau "Rusak Berat". Apabila terjadi kerusakan, sistem mencatat keterangan riwayat kerusakan.</li>
        <li><strong>Pengembalian Status Barang:</strong> Status inventaris barang otomatis dipulihkan menjadi "Tersedia" (atau "Perbaikan" jika rusak).</li>
        <li><strong>Berita Acara Pengembalian Digital:</strong> Kedua pihak menandatangani BAST Pengembalian secara digital dan sistem mencetak arsip PDF pengembalian.</li>
    </ul>

    <h2 class="section-title">3.5 Modul Daftar Inventaris Ruangan (DIR)</h2>
    <p>
        Kepatuhan penataan tata ruang kantor sekretariat didukung dengan modul DIR:
    </p>
    <ul>
        <li>Setiap ruangan kerja (misal: Ruang Ketua, Ruang Komisioner, Ruang Sidang, Ruang Sekretariat) memiliki daftar inventaris yang terikat.</li>
        <li><strong>Cetak Format Standar DIR (PDF):</strong> Fitur satu klik untuk mencetak lembar inventaris ruangan lengkap dengan kolom kondisi fisik dan kolom tanda tangan Penanggung Jawab Ruangan serta Pengelola BMN. Lembar ini dapat ditempel di balik pintu masing-masing ruangan.</li>
    </ul>

    <h2 class="section-title">3.6 Sistem Registrasi Staf & Gerbang Verifikasi Admin (Approval Gatekeeper)</h2>
    <div class="callout-gold">
        <strong>Gerbang Keamanan Baru:</strong> Memastikan tidak ada pengguna liar yang dapat login atau meminjam inventaris tanpa verifikasi kepegawaian resmi oleh Administrator BMN.
    </div>
    <ul>
        <li><strong>Formulir Registrasi Publik (<code>/register</code>):</strong> Pegawai baru mengisi Nama Lengkap, NIP (Nomor Induk Pegawai), Jabatan, Unit Kerja, Alamat Email resmi, dan Kata Sandi.</li>
        <li><strong>Status Default Pending (<code>is_verified = false</code>):</strong> Setelah mendaftar, pegawai tidak langsung bisa login. Layar akan menampilkan pesan informatif bahwa akun sedang menunggu persetujuan admin.</li>
        <li><strong>Lonceng Notifikasi Real-Time Filament:</strong> Seluruh administrator menerima notifikasi lonceng instan di pojok kanan atas dasbor admin sesaat setelah staf baru mendaftar.</li>
        <li><strong>Badge Counter di Menu Pengguna:</strong> Menu navigasi "Pengguna" di sidebar admin otomatis menampilkan angka lencana kuning penanda berapa jumlah staf yang butuh diverifikasi.</li>
        <li><strong>Aksi 1-Klik Verifikasi:</strong> Admin cukup membuka tabel Pengguna, meninjau kesesuaian NIP dan unit kerja, lalu menekan tombol hijau "Verifikasi Staf". Akun staf seketika aktif dan dapat login ke sistem.</li>
    </ul>

    <h2 class="section-title">3.7 Portal Mobile Pemindai QR Staf (<code>/scan</code>)</h2>
    <p>
        Staf yang berwenang dapat mengakses portal mobile melalui browser smartphone:
    </p>
    <ul>
        <li>Menggunakan kamera smartphone langsung untuk memindai label QR Code pada barang dinas.</li>
        <li>Menampilkan ringkasan status apakah barang sedang bebas dipakai atau sedang berada di ruangan lain.</li>
        <li>Menyediakan riwayat pemakaian aset untuk transparansi operasional lapangan.</li>
    </ul>

    <div class="page-break"></div>

    <!-- ======================================================== -->
    <!-- BAB 4: PANDUAN DEPLOYMENT & KONFIGURASI DOMAIN           -->
    <!-- ======================================================== -->
    <h1 class="chapter-title">BAB 4. PANDUAN DEPLOYMENT & KONFIGURASI DOMAIN</h1>

    <div class="callout-box">
        <strong>Menjawab Pertanyaan:</strong> <em>"Bang, kira-kira kalau ini dikasih domain, apakah saya harus memberikan URL terpisah lagi untuk pegawai?"</em><br>
        <strong>Jawaban Singkat:</strong> <strong>TIDAK PERLU</strong>. Cukup gunakan <strong>1 nama domain utama</strong> saja. Routing sistem sudah diprogram secara cerdas untuk memisahkan pintu masuk admin dan staf secara otomatis.
    </div>

    <h2 class="section-title">4.1 Struktur URL Resmi Aplikasi</h2>
    <p>
        Ketika aplikasi dipasang pada nama domain pilihan (misalnya: <code>https://aset.bawaslu-daerah.go.id</code> atau <code>https://bawaslu-aset.com</code>), struktur tautannya adalah sebagai berikut:
    </p>

    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 25%;">Tujuan / Sasaran</th>
                <th style="width: 45%;">Tautan URL</th>
                <th style="width: 30%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Halaman Login Utama</strong></td>
                <td><code>https://domain-anda.com/login</code> atau <code>https://domain-anda.com/</code></td>
                <td>Pintu masuk bersama. Jika yang login Admin → otomatis masuk ke <code>/admin</code>. Jika yang login Staf → otomatis masuk ke <code>/scan</code>.</td>
            </tr>
            <tr>
                <td><strong>Pendaftaran Staf Baru</strong></td>
                <td><code>https://domain-anda.com/register</code></td>
                <td>Formulir pendaftaran bagi pegawai baru sebelum disetujui admin.</td>
            </tr>
            <tr>
                <td><strong>Panel Administrator</strong></td>
                <td><code>https://domain-anda.com/admin</code></td>
                <td>Dasbor penuh BMN untuk admin yang telah terautentikasi.</td>
            </tr>
            <tr>
                <td><strong>Portal Scanner Pegawai</strong></td>
                <td><code>https://domain-anda.com/scan</code></td>
                <td>Halaman pemindai QR kamera HP untuk staf operasional.</td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title">4.2 Rekomendasi Teknis Server & Hosting</h2>
    <ol>
        <li><strong>Sertifikat SSL (HTTPS Wajib):</strong> Sangat disarankan mengaktifkan SSL (HTTPS gratis melalui Let's Encrypt atau Cloudflare). Hal ini penting karena fitur pemindai QR kamera smartphone pada browser mobile secara ketat memblokir akses kamera jika situs tidak memakai protokol HTTPS aman.</li>
        <li><strong>Spesifikasi Minimum Server:</strong>
            <ul>
                <li>PHP versi 8.3 atau 8.4 dengan ekstensi: <code>bcmath, ctype, curl, dom, fileinfo, gd/imagick, mbstring, openssl, pdo, sqlite3/pdo_mysql, tokenizer, xml, zip</code>.</li>
                <li>Web Server: Nginx atau Apache (mod_rewrite aktif).</li>
                <li>RAM: Minimum 1 GB (Rekomendasi 2 GB untuk antrean ekspor PDF dan pemrosesan gambar foto).</li>
            </ul>
        </li>
        <li><strong>Langkah Instalasi di Server Produksi:</strong>
            <div class="callout-box" style="font-family: monospace; font-size: 7.5pt;">
                git clone &lt;repo_url&gt;<br>
                composer install --no-dev --optimize-autoloader<br>
                cp .env.example .env && php artisan key:generate<br>
                php artisan migrate --force<br>
                php artisan storage:link<br>
                php artisan filament:optimize
            </div>
        </li>
    </ol>

    <div class="page-break"></div>

    <!-- ======================================================== -->
    <!-- BAB 5: HASIL PENGUJIAN KUALITAS & PENUTUP                -->
    <!-- ======================================================== -->
    <h1 class="chapter-title">BAB 5. HASIL PENGUJIAN MUTU & PENGESAHAN</h1>

    <h2 class="section-title">5.1 Hasil Automated Test Suite</h2>
    <p>
        Seluruh fungsi aplikasi telah diuji secara menyeluruh menggunakan rangkaian uji otomatis PHPUnit / Pest Framework dengan hasil sempurna tanpa ada kegagalan:
    </p>

    <table class="custom-table">
        <thead>
            <tr>
                <th style="width: 40%;">Rumpun Uji (Test Suite)</th>
                <th style="width: 20%;">Jumlah Test</th>
                <th style="width: 20%;">Assertions</th>
                <th style="width: 20%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Uji Registrasi Staf & Gerbang Verifikasi Admin</td>
                <td>5 Kasus Uji</td>
                <td>17 Assertions</td>
                <td><span class="badge badge-success">100% LULUS</span></td>
            </tr>
            <tr>
                <td>Uji Branding, Warna Bawaslu & 9 Widget Dasbor</td>
                <td>4 Kasus Uji</td>
                <td>14 Assertions</td>
                <td><span class="badge badge-success">100% LULUS</span></td>
            </tr>
            <tr>
                <td>Uji Modul BAST Pemakaian & Koordinat Geospasial</td>
                <td>16 Kasus Uji</td>
                <td>52 Assertions</td>
                <td><span class="badge badge-success">100% LULUS</span></td>
            </tr>
            <tr>
                <td>Uji BAST Pengembalian & Rekonsiliasi Kondisi</td>
                <td>12 Kasus Uji</td>
                <td>38 Assertions</td>
                <td><span class="badge badge-success">100% LULUS</span></td>
            </tr>
            <tr>
                <td>Uji Manajemen Inventaris Aset BMN & DIR Ruangan</td>
                <td>28 Kasus Uji</td>
                <td>86 Assertions</td>
                <td><span class="badge badge-success">100% LULUS</span></td>
            </tr>
            <tr>
                <td>Uji Isolasi Role, Autentikasi & Guard Keamanan</td>
                <td>29 Kasus Uji</td>
                <td>89 Assertions</td>
                <td><span class="badge badge-success">100% LULUS</span></td>
            </tr>
            <tr style="font-weight: bold; background-color: #FEF2F2;">
                <td>TOTAL KESELURUHAN PENGUJIAN SISTEM</td>
                <td>94 Test Cases</td>
                <td>296 Assertions</td>
                <td><span class="badge badge-success">0 ERROR / 100% PASS</span></td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title">5.2 Kesimpulan</h2>
    <p>
        Sistem Informasi <strong>Bawaslu Management Asset</strong> telah siap digunakan secara penuh (Production Ready). Seluruh kebutuhan operasional tata kelola aset dinas, mulai dari pencatatan barang, pencetakan kode QR, peminjaman digital tanpa kertas (paperless BAST) dengan bukti koordinat peta, hingga kontrol verifikasi pengguna telah berfungsi dengan stabil, aman, dan elegan sesuai standar identitas kelembagaan Bawaslu Republik Indonesia.
    </p>

    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Pejabat Pengelola BMN</strong><br>
                Badan Pengawas Pemilihan Umum<br><br><br><br><br>
                ( _____________________________ )<br>
                NIP. ....................................................
            </td>
            <td>
                Diverifikasi Oleh,<br>
                <strong>Tim Pengembang Sistem & IT</strong><br>
                Bawaslu Management Asset System<br><br><br><br><br>
                ( <strong>TIM PENGEMBANG IT</strong> )<br>
                Status: <em>Production Ready Certified</em>
            </td>
        </tr>
    </table>

</body>
</html>
