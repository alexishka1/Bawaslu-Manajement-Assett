<?php

namespace App\Filament\Resources\BastPengembalianHeaders\Schemas;

use App\Models\BastPemakaianDetail;
use App\Models\Item;
use App\Models\RefPegawai;
use App\Models\RefPejabat;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BastPengembalianHeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokumen Pengembalian')
                    ->description('Lengkapi data pengembalian barang BMN.')
                    ->columns(3)
                    ->schema([
                        DatePicker::make('tanggal')
                            ->label('Tanggal Pengembalian')
                            ->default(now())
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('lokasi')
                            ->label('Lokasi')
                            ->default('Kantor Bawaslu')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Select::make('status_dokumen')
                            ->label('Status Dokumen')
                            ->required()
                            ->options([
                                'draft' => 'Draft (Belum Selesai)',
                                'final' => 'Final (Terbitkan & Kembalikan Barang)',
                            ])
                            ->default('draft')
                            ->native(false)
                            ->helperText('Saat status Final, barang yang dicentang otomatis kembali berstatus Tersedia di sistem.')
                            ->columnSpan(1),
                    ]),

                Section::make('Para Pihak Serah Terima')
                    ->description('Tentukan pihak yang mengembalikan dan pejabat yang menerima kembali barang.')
                    ->columns(2)
                    ->schema([
                        Select::make('pihak_menyerahkan_tipe')
                            ->label('Kategori Pihak yang Mengembalikan')
                            ->required()
                            ->options([
                                'internal' => 'Pegawai Internal Bawaslu',
                                'eksternal' => 'Pihak Eksternal / Mitra',
                            ])
                            ->default('internal')
                            ->native(false)
                            ->live()
                            ->columnSpan(1),

                        Select::make('pihak_menyerahkan_nip')
                            ->label('Nama Pegawai yang Mengembalikan')
                            ->options(fn () => RefPegawai::where('status', 'aktif')->pluck('nama', 'nip'))
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->visible(fn ($get) => $get('pihak_menyerahkan_tipe') === 'internal')
                            ->required(fn ($get) => $get('pihak_menyerahkan_tipe') === 'internal')
                            ->columnSpan(1),

                        TextInput::make('pihak_menyerahkan_nama_manual')
                            ->label('Nama Lengkap Pihak Eksternal')
                            ->visible(fn ($get) => $get('pihak_menyerahkan_tipe') === 'eksternal')
                            ->required(fn ($get) => $get('pihak_menyerahkan_tipe') === 'eksternal')
                            ->maxLength(255)
                            ->columnSpan(1),

                        Select::make('pihak_menerima_nip')
                            ->label('Pejabat Penerima BMN')
                            ->required()
                            ->options(fn () => RefPejabat::where('status', 'aktif')->pluck('nama', 'nip'))
                            ->searchable()
                            ->native(false)
                            ->columnSpan(2),
                    ]),

                Section::make('Daftar Barang yang Dikembalikan (Dukungan Pengembalian Parsial)')
                    ->description('Pilih barang yang sedang dipegang oleh peminjam untuk dikembalikan.')
                    ->schema([
                        Repeater::make('details')
                            ->relationship('details')
                            ->label('Rincian Barang Dikembalikan')
                            ->columns(3)
                            ->schema([
                                Select::make('bast_pemakaian_detail_id')
                                    ->label('Pilih Barang dari Riwayat Pemakaian Aktif')
                                    ->required()
                                    ->options(function ($get) {
                                        $nip = $get('../../pihak_menyerahkan_nip');
                                        $query = BastPemakaianDetail::where('status_item', 'dipakai')
                                            ->with(['header', 'item']);

                                        if ($nip) {
                                            $query->whereHas('header', fn ($q) => $q->where('pihak_kedua_nip', $nip));
                                        }

                                        return $query->get()->mapWithKeys(function ($d) {
                                            $itemName = $d->item ? $d->item->kode_bmn.' — '.$d->item->nama_barang : 'Item #'.$d->item_id;
                                            $bastNomor = $d->header?->nomor_bast ?? 'DRAFT';

                                            return [$d->id => "{$itemName} (BAST Asal: {$bastNomor})"];
                                        });
                                    })
                                    ->searchable()
                                    ->native(false)
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $detail = BastPemakaianDetail::find($state);
                                        if ($detail) {
                                            $set('item_id', $detail->item_id);
                                        }
                                    })
                                    ->columnSpan(2),

                                Select::make('kondisi_saat_kembali')
                                    ->label('Kondisi Saat Kembali')
                                    ->options([
                                        'Baik' => 'Baik',
                                        'Rusak Ringan' => 'Rusak Ringan',
                                        'Rusak Berat' => 'Rusak Berat',
                                        'Hilang' => 'Hilang',
                                    ])
                                    ->default('Baik')
                                    ->required()
                                    ->native(false)
                                    ->columnSpan(1),

                                Select::make('item_id')
                                    ->label('Barang yang Dikembalikan')
                                    ->options(fn () => Item::all()->mapWithKeys(fn ($item) => [$item->id => "{$item->kode_bmn} — {$item->nama_barang}"]))
                                    ->searchable()
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('catatan_kerusakan')
                                    ->label('Catatan / Keterangan Kondisi')
                                    ->placeholder('Opsional: kelengkapan charger, dus, atau catatan fisik...')
                                    ->columnSpan(2),
                            ])
                            ->addActionLabel('+ Tambah Barang yang Dikembalikan')
                            ->minItems(1)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
