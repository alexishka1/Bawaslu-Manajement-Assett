<?php

namespace App\Filament\Resources\BastPemakaianHeaders\Schemas;

use App\Models\Item;
use App\Models\RefPegawai;
use App\Models\RefPejabat;
use Fahiem\FilamentPinpoint\Pinpoint;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BastPemakaianHeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokumen BAST')
                    ->description('Lengkapi data umum dokumen serah terima BMN.')
                    ->columns(2)
                    ->schema([
                        Select::make('jenis_bast')
                            ->label('Jenis Dokumen BAST')
                            ->required()
                            ->options([
                                'BAST_PEMAKAIAN_KIB' => 'BAST Pemakaian (KIB)',
                                'BAST_PEMAKAIAN_NON_KIB' => 'BAST Pemakaian (Non-KIB)',
                                'BAST_PINJAM_PAKAI' => 'BAST Pinjam Pakai',
                            ])
                            ->default('BAST_PEMAKAIAN_KIB')
                            ->native(false)
                            ->live()
                            ->columnSpan(1),

                        Select::make('status_dokumen')
                            ->label('Status Dokumen')
                            ->required()
                            ->options([
                                'draft' => 'Draft (Belum Diterbitkan)',
                                'final' => 'Final (Terbitkan Nomor & Kunci Barang)',
                            ])
                            ->default('draft')
                            ->native(false)
                            ->helperText('Jika disimpan sebagai Final, nomor BAST akan digenerate otomatis dan status barang berubah menjadi Terpakai.')
                            ->columnSpan(1),

                        DatePicker::make('tanggal_bast')
                            ->label('Tanggal Serah Terima')
                            ->default(now())
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('lokasi')
                            ->label('Lokasi Serah Terima')
                            ->default('Kantor Bawaslu')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                    ]),

                Section::make('Pihak-Pihak Terkait')
                    ->description('Tentukan pihak pertama (pejabat penyerah) dan pihak kedua (penerima barang).')
                    ->columns(2)
                    ->schema([
                        Select::make('pihak_pertama_nip')
                            ->label('Pihak Pertama (Pejabat Penyerah)')
                            ->required()
                            ->options(fn () => RefPejabat::where('status', 'aktif')->pluck('nama', 'nip'))
                            ->searchable()
                            ->native(false)
                            ->columnSpan(2),

                        Select::make('pihak_kedua_tipe')
                            ->label('Kategori Penerima (Pihak Kedua)')
                            ->required()
                            ->options([
                                'internal' => 'Pegawai Internal Bawaslu',
                                'eksternal' => 'Pihak Eksternal / Mitra Kerja',
                            ])
                            ->default('internal')
                            ->native(false)
                            ->live()
                            ->columnSpan(1),

                        Select::make('pihak_kedua_nip')
                            ->label('Nama Pegawai Penerima')
                            ->options(fn () => RefPegawai::where('status', 'aktif')->pluck('nama', 'nip'))
                            ->searchable()
                            ->native(false)
                            ->visible(fn ($get) => $get('pihak_kedua_tipe') === 'internal')
                            ->required(fn ($get) => $get('pihak_kedua_tipe') === 'internal')
                            ->columnSpan(1),

                        TextInput::make('pihak_kedua_nama_manual')
                            ->label('Nama Lengkap / Instansi Eksternal')
                            ->placeholder('Contoh: Bpk. Bambang - KPU Provinsi')
                            ->visible(fn ($get) => $get('pihak_kedua_tipe') === 'eksternal')
                            ->required(fn ($get) => $get('pihak_kedua_tipe') === 'eksternal')
                            ->maxLength(255)
                            ->columnSpan(1),
                    ]),

                Section::make('Bukti Lokasi Peminjam')
                    ->description('Input alamat peminjam dan tentukan titik lokasi yang akurat di peta sebagai bukti tracking.')
                    ->schema([
                        Textarea::make('alamat_peminjam')
                            ->label('Alamat Lengkap Peminjam / Kantor Tujuan')
                            ->placeholder('Ketik nama jalan, RT/RW, kelurahan, kecamatan, atau nama gedung...')
                            ->rows(2)
                            ->columnSpanFull(),

                        Pinpoint::make('location')
                            ->label('Titik Peta Lokasi (OpenStreetMap / Leaflet)')
                            ->provider('leaflet')
                            ->latField('latitude')
                            ->lngField('longitude')
                            ->addressField('alamat_peminjam')
                            ->defaultLocation(-5.3971, 105.2668)
                            ->defaultZoom(13)
                            ->height(400)
                            ->draggable()
                            ->searchable()
                            ->helperText('Gunakan kotak pencarian di dalam peta atau geser pin ke titik rumah/kantor peminjam.')
                            ->columnSpanFull(),

                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->readOnly()
                            ->columnSpan(1),

                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->readOnly()
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Daftar Barang BMN yang Diserahterimakan')
                    ->description('Pilih barang yang berstatus Tersedia untuk dimasukkan ke dalam dokumen BAST ini.')
                    ->schema([
                        Repeater::make('details')
                            ->relationship('details')
                            ->label('Rincian Barang')
                            ->columns(3)
                            ->schema([
                                Select::make('item_id')
                                    ->label('Pilih Barang BMN')
                                    ->required()
                                    ->options(function ($record, $get) {
                                        $currentId = $get('item_id') ?? $record?->item_id;

                                        return Item::where('status', 'tersedia')
                                            ->when($currentId, fn ($q) => $q->orWhere('id', $currentId))
                                            ->get()
                                            ->mapWithKeys(fn ($item) => [$item->id => $item->kode_bmn.' — '.$item->nama_barang.' ('.$item->kategori.')']);
                                    })
                                    ->searchable()
                                    ->native(false)
                                    ->columnSpan(2),

                                Select::make('kondisi_saat_diserahkan')
                                    ->label('Kondisi Saat Diserahkan')
                                    ->options([
                                        'Baik' => 'Baik',
                                        'Rusak Ringan' => 'Rusak Ringan',
                                    ])
                                    ->default('Baik')
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(1),
                            ])
                            ->addActionLabel('+ Tambah Barang BMN')
                            ->minItems(1)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
