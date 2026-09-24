<?php

namespace App\Filament\Resources\BastPemakaianHeaders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BastPemakaianHeaderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokumen')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('nomor_bast')
                            ->label('Nomor BAST')
                            ->weight('bold')
                            ->placeholder('DRAFT (Belum Diterbitkan)'),

                        TextEntry::make('jenis_bast')
                            ->label('Jenis Dokumen')
                            ->badge()
                            ->color('info')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'BAST_PEMAKAIAN_KIB' => 'Pemakaian (KIB)',
                                'BAST_PEMAKAIAN_NON_KIB' => 'Pemakaian (Non-KIB)',
                                'BAST_PINJAM_PAKAI' => 'Pinjam Pakai',
                                default => $state,
                            }),

                        TextEntry::make('status_dokumen')
                            ->label('Status Dokumen')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'final' ? 'success' : 'warning')
                            ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                        TextEntry::make('tanggal_bast')
                            ->label('Tanggal Serah Terima')
                            ->date('d F Y'),

                        TextEntry::make('lokasi')
                            ->label('Lokasi Serah Terima'),

                        TextEntry::make('pembuat.name')
                            ->label('Petugas Input')
                            ->placeholder('-'),
                    ]),

                Section::make('Para Pihak')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('pihakPertama.nama')
                            ->label('Pihak Pertama (Pejabat Penyerah)')
                            ->weight('bold')
                            ->helperText(fn ($record) => $record->pihakPertama?->jabatan.' (NIP: '.$record->pihak_pertama_nip.')'),

                        TextEntry::make('pihak_kedua_display')
                            ->label('Pihak Kedua (Penerima)')
                            ->weight('bold')
                            ->helperText(fn ($record) => $record->pihak_kedua_tipe === 'internal' ? ($record->pihakKedua?->jabatan.' - '.$record->pihakKedua?->unit_kerja) : 'Pihak Eksternal'),
                    ]),

                Section::make('Lokasi Peminjam')
                    ->columns(2)
                    ->visible(fn ($record) => $record?->hasLokasi() ?? false)
                    ->schema([
                        TextEntry::make('alamat_peminjam')
                            ->label('Alamat')
                            ->columnSpanFull(),

                        TextEntry::make('latitude')
                            ->label('Koordinat')
                            ->formatStateUsing(fn ($record) => "{$record->latitude}, {$record->longitude}"),

                        TextEntry::make('lihat_peta')
                            ->label('')
                            ->state('📍 Buka di Peta')
                            ->url(fn ($record) => "https://www.openstreetmap.org/?mlat={$record->latitude}&mlon={$record->longitude}#map=17/{$record->latitude}/{$record->longitude}")
                            ->openUrlInNewTab()
                            ->color('primary')
                            ->weight('bold'),
                    ]),

                Section::make('Daftar Barang BMN Diserahterimakan')
                    ->description('Rincian aset yang tercantum dalam BAST ini.')
                    ->schema([
                        RepeatableEntry::make('details')
                            ->label('')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('item.kode_bmn')
                                    ->label('Kode BMN')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('item.nama_barang')
                                    ->label('Nama Barang')
                                    ->helperText(fn ($record) => 'Kategori: '.($record->item?->kategori ?? '-')),
                                TextEntry::make('kondisi_saat_diserahkan')
                                    ->label('Kondisi')
                                    ->badge()
                                    ->color('success'),
                            ]),
                    ]),
            ]);
    }
}
