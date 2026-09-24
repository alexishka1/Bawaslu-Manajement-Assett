<?php

namespace App\Filament\Resources\ConfigPenomorans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfigPenomoranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konfigurasi Format Nomor Dokumen')
                    ->description('Tentukan format penomoran otomatis untuk setiap jenis BAST.')
                    ->columns(2)
                    ->schema([
                        Select::make('jenis_dokumen')
                            ->label('Jenis Dokumen BAST')
                            ->required()
                            ->options([
                                'BAST_PEMAKAIAN_KIB' => 'BAST Pemakaian (KIB)',
                                'BAST_PEMAKAIAN_NON_KIB' => 'BAST Pemakaian (Non-KIB)',
                                'BAST_PINJAM_PAKAI' => 'BAST Pinjam Pakai',
                                'BAST_PENGEMBALIAN' => 'BAST Pengembalian',
                            ])
                            ->native(false)
                            ->columnSpan(1),

                        TextInput::make('tahun_berjalan')
                            ->label('Tahun Berjalan')
                            ->numeric()
                            ->default((int) date('Y'))
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('format_nomor')
                            ->label('Format Penomoran')
                            ->required()
                            ->placeholder('{counter}/BAST-KIB/{tahun}')
                            ->helperText('Gunakan placeholder {counter} untuk nomor 3 digit (contoh: 001) atau {tahun} untuk 4 digit tahun.')
                            ->columnSpan(1),

                        TextInput::make('counter_terakhir')
                            ->label('Counter Terakhir')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Nomor urut terakhir yang telah diterbitkan pada tahun ini.')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
