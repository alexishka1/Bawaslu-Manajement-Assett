<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
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

                        Select::make('ref_ruangan_id')
                            ->label('Penempatan Ruangan')
                            ->relationship('ruangan', 'nama_ruangan')
                            ->searchable()
                            ->preload()
                            ->placeholder('-- Pilih Ruangan Kantor --')
                            ->columnSpan(1),

                        TextInput::make('lokasi_simpan')
                            ->label('Lokasi Detail / Rak')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Rak B3, Meja Staf, Lemari Arsip')
                            ->columnSpan(1),
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
