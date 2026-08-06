<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Schemas\Components\TextEntry;
use Filament\Schemas\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Barang')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('kode_bmn')
                            ->label('Kode BMN')
                            ->weight('bold')
                            ->copyable(),
                        TextEntry::make('nama_barang')
                            ->label('Nama Barang'),
                        TextEntry::make('kategori')
                            ->label('Kategori')
                            ->badge(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'tersedia' => 'success',
                                'terpakai' => 'info',
                                'servis' => 'warning',
                                'rusak' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                        TextEntry::make('lokasi_simpan')
                            ->label('Lokasi Penyimpanan'),
                        TextEntry::make('qr_code')
                            ->label('Isi Data QR')
                            ->placeholder('-'),
                    ]),

                Section::make('Media')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('foto')
                            ->label('Foto Barang')
                            ->placeholder('Tidak ada foto'),
                        TextEntry::make('created_at')
                            ->label('Ditambahkan Pada')
                            ->dateTime('d M Y, H:i'),
                        TextEntry::make('updated_at')
                            ->label('Terakhir Diubah')
                            ->dateTime('d M Y, H:i'),
                    ]),
            ]);
    }
}


