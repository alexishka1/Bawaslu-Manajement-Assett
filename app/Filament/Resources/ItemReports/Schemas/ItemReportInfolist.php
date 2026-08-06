<?php

namespace App\Filament\Resources\ItemReports\Schemas;

use Filament\Schemas\Components\TextEntry;
use Filament\Schemas\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Laporan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('item.nama_barang')
                            ->label('Barang Dilaporkan')
                            ->weight('bold'),
                        TextEntry::make('user.name')
                            ->label('Nama Pelapor'),
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
                        TextEntry::make('created_at')
                            ->label('Waktu Pelaporan')
                            ->dateTime('d M Y, H:i'),
                        TextEntry::make('catatan')
                            ->label('Catatan Staf')
                            ->columnSpanFull(),
                    ]),
                Section::make('Bukti Fisik')
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


