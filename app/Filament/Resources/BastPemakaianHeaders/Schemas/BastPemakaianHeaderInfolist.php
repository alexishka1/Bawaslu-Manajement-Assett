<?php

namespace App\Filament\Resources\BastPemakaianHeaders\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\TextEntry;
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
                            ->description(fn ($record) => $record->pihakPertama?->jabatan . ' (NIP: ' . $record->pihak_pertama_nip . ')'),

                        TextEntry::make('pihak_kedua_display')
                            ->label('Pihak Kedua (Penerima)')
                            ->weight('bold')
                            ->description(fn ($record) => $record->pihak_kedua_tipe === 'internal' ? ($record->pihakKedua?->jabatan . ' - ' . $record->pihakKedua?->unit_kerja) : 'Pihak Eksternal'),
                    ]),
            ]);
    }
}