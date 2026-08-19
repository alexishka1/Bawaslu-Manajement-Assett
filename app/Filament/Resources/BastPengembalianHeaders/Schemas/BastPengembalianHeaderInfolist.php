<?php

namespace App\Filament\Resources\BastPengembalianHeaders\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TextEntry;
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
                            ->description(fn ($record) => $record->pihakMenerima?->jabatan . ' (NIP: ' . $record->pihak_menerima_nip . ')'),
                    ]),
            ]);
    }
}