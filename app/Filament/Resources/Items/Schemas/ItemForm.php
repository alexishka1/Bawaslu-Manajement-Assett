<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Schemas\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Barang')
                    ->description('Lengkapi data barang BMN berikut.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('kode_bmn')
                            ->label('Kode BMN')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('Contoh: BMN-ELK-001')
                            ->columnSpan(1),

                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Laptop ASUS VivoBook')
                            ->columnSpan(1),

                        Select::make('kategori')
                            ->label('Kategori')
                            ->required()
                            ->options([
                                'Elektronik' => 'Elektronik',
                                'ATK' => 'ATK',
                                'Kendaraan' => 'Kendaraan',
                                'Mebel' => 'Mebel',
                                'Arsip' => 'Arsip',
                            ])
                            ->native(false)
                            ->searchable()
                            ->columnSpan(1),

                        Select::make('status')
                            ->label('Status Barang')
                            ->required()
                            ->options([
                                'tersedia' => 'Tersedia',
                                'terpakai' => 'Terpakai',
                                'servis' => 'Servis',
                                'rusak' => 'Rusak',
                            ])
                            ->default('tersedia')
                            ->native(false)
                            ->columnSpan(1),

                        TextInput::make('lokasi_simpan')
                            ->label('Lokasi Penyimpanan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Gudang Lantai 2, Rak A3')
                            ->columnSpan(2),
                    ]),

                Section::make('Media & Identifikasi')
                    ->description('Upload foto dan data QR Code barang.')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        FileUpload::make('foto')
                            ->label('Foto Barang')
                            ->image()
                            ->imageEditor()
                            ->directory('items')
                            ->maxSize(2048)
                            ->columnSpan(1),

                        TextInput::make('qr_code')
                            ->label('QR Code')
                            ->maxLength(255)
                            ->placeholder('Otomatis atau manual')
                            ->columnSpan(1),
                    ]),
            ]);
    }
}


