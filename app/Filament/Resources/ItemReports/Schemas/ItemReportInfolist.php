<?php

namespace App\Filament\Resources\ItemReports\Schemas;

use Filament\Schemas\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TextEntry;
use Filament\Schemas\Schema;

class ItemReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Laporan')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('item.nama_barang')
                            ->label('Barang Dilaporkan')
                            ->weight('bold')
                            ->description(fn ($record) => $record->item?->kode_bmn ?? '-'),

                        TextEntry::make('user.name')
                            ->label('Nama Pelapor')
                            ->placeholder('-'),

                        TextEntry::make('kondisi_aktual')
                            ->label('Kondisi Aktual (Laporan)')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'tersedia' => 'success',
                                'terpakai' => 'info',
                                'servis' => 'warning',
                                'rusak', 'hilang' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                        TextEntry::make('status_validasi')
                            ->label('Status Validasi')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'divalidasi' => 'success',
                                'menunggu' => 'warning',
                                'ditolak' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                        TextEntry::make('validator.name')
                            ->label('Divalidasi Oleh')
                            ->placeholder('Belum divalidasi'),

                        TextEntry::make('tanggal_validasi')
                            ->label('Waktu Validasi')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),

                        TextEntry::make('created_at')
                            ->label('Waktu Pelaporan')
                            ->dateTime('d M Y, H:i'),

                        TextEntry::make('catatan')
                            ->label('Catatan Staf')
                            ->columnSpanFull()
                            ->placeholder('Tidak ada catatan tambahan.'),
                    ]),

                Section::make('Bukti Fisik Kamera')
                    ->schema([
                        ImageEntry::make('foto_bukti')
                            ->label('Foto dari Kamera Lapangan')
                            ->columnSpanFull()
                            ->width('100%')
                            ->height('auto'),
                    ]),
            ]);
    }
}