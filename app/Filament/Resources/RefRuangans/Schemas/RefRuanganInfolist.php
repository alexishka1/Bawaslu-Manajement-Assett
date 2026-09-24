<?php

namespace App\Filament\Resources\RefRuangans\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RefRuanganInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Ruangan')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('kode_ruangan')
                            ->label('Kode Ruangan')
                            ->weight('bold')
                            ->color('primary')
                            ->fontFamily('mono'),

                        TextEntry::make('nama_ruangan')
                            ->label('Nama Ruangan')
                            ->weight('bold'),

                        TextEntry::make('lantai')
                            ->label('Lantai')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('gedung')
                            ->label('Gedung / Sayap')
                            ->placeholder('Gedung Utama'),

                        TextEntry::make('keterangan')
                            ->label('Fungsi / Keterangan')
                            ->columnSpan(2)
                            ->placeholder('-'),
                    ]),

                Section::make('Penanggung Jawab Ruangan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('penanggung_jawab')
                            ->label('Nama Penanggung Jawab')
                            ->weight('bold')
                            ->placeholder('-'),

                        TextEntry::make('nip_penanggung_jawab')
                            ->label('NIP Penanggung Jawab')
                            ->placeholder('-'),
                    ]),

                Section::make('Daftar Aset BMN di Ruangan Ini (DIR)')
                    ->description('Seluruh aset BMN yang saat ini terdaftar dan ditempatkan di ruangan ini.')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->columns(3)
                            ->schema([
                                TextEntry::make('kode_bmn')
                                    ->label('Kode BMN')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('nama_barang')
                                    ->label('Nama Barang')
                                    ->helperText(fn ($record) => 'Kategori: '.$record->kategori),

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
                            ]),
                    ]),
            ]);
    }
}
