<?php

namespace App\Filament\Resources\ItemReports\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Laporan Lapangan')
                    ->description('Data laporan kondisi fisik barang hasil pemantauan/scan staf.')
                    ->columns(2)
                    ->schema([
                        Select::make('item_id')
                            ->label('Barang BMN')
                            ->relationship('item', 'nama_barang')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(1),

                        Select::make('user_id')
                            ->label('Staf Pelapor')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(1),

                        Select::make('kondisi_aktual')
                            ->label('Kondisi Fisik Aktual')
                            ->required()
                            ->options([
                                'tersedia' => 'Tersedia / Siap Digunakan',
                                'terpakai' => 'Sedang Dipakai / Digunakan',
                                'servis' => 'Dalam Perbaikan / Servis',
                                'rusak' => 'Rusak (Perlu Penanganan)',
                                'hilang' => 'Hilang / Tidak Ditemukan',
                            ])
                            ->native(false)
                            ->columnSpan(1),

                        Select::make('status_validasi')
                            ->label('Status Validasi Admin')
                            ->required()
                            ->options([
                                'menunggu' => 'Menunggu Validasi',
                                'divalidasi' => 'Divalidasi (Disetujui)',
                                'ditolak' => 'Ditolak',
                            ])
                            ->default('menunggu')
                            ->native(false)
                            ->columnSpan(1),

                        Textarea::make('catatan')
                            ->label('Catatan Hasil Pemantauan')
                            ->placeholder('Jelaskan kondisi detail barang atau temuan lapangan...')
                            ->columnSpanFull(),

                        FileUpload::make('foto_bukti')
                            ->label('Foto Bukti Lapangan')
                            ->image()
                            ->directory('reports')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
