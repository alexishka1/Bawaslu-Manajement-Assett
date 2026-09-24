<?php

namespace App\Filament\Resources\BastPengembalianHeaders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BastPengembalianHeaderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokumen Pengembalian')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('nomor_bast_pengembalian')
                            ->label('Nomor BAST Pengembalian')
                            ->weight('bold')
                            ->placeholder('DRAFT (Belum Diterbitkan)'),

                        TextEntry::make('tanggal')
                            ->label('Tanggal Pengembalian')
                            ->date('d F Y'),

                        TextEntry::make('status_dokumen')
                            ->label('Status Dokumen')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'final' ? 'success' : 'warning')
                            ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                        TextEntry::make('lokasi')
                            ->label('Lokasi Serah Terima'),

                        TextEntry::make('pembuat.name')
                            ->label('Petugas Input')
                            ->placeholder('-'),
                    ]),

                Section::make('Para Pihak')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('pihak_menyerahkan_display')
                            ->label('Pihak yang Menyerahkan (Pengembali)')
                            ->weight('bold'),

                        TextEntry::make('pihakMenerima.nama')
                            ->label('Pihak yang Menerima (Pejabat BMN)')
                            ->weight('bold')
                            ->helperText(fn ($record) => $record->pihakMenerima?->jabatan.' (NIP: '.$record->pihak_menerima_nip.')'),
                    ]),

                Section::make('Daftar Barang BMN yang Dikembalikan')
                    ->description('Rincian aset yang diserahkan kembali.')
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
                                TextEntry::make('kondisi_saat_kembali')
                                    ->label('Kondisi Saat Kembali')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Baik' => 'success',
                                        'Rusak Ringan' => 'warning',
                                        'Rusak Berat', 'Hilang' => 'danger',
                                        default => 'gray',
                                    }),
                                TextEntry::make('catatan_kerusakan')
                                    ->label('Catatan Kondisi')
                                    ->columnSpanFull()
                                    ->placeholder('Tidak ada catatan khusus.'),
                            ]),
                    ]),
            ]);
    }
}
