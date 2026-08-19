<?php

namespace App\Filament\Resources\RefPegawais\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class RefPegawaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pegawai')
                    ->description('Lengkapi data pegawai / penerima barang.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nip')
                            ->label('NIP / Identitas')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->placeholder('Contoh: 198501012010011001')
                            ->columnSpan(1),

                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Ahmad Fauzi, S.Kom')
                            ->columnSpan(1),

                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Staf Pengawasan')
                            ->columnSpan(1),

                        TextInput::make('unit_kerja')
                            ->label('Unit Kerja / Bagian')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Sekretariat / Divisi SDM')
                            ->columnSpan(1),

                        Select::make('status')
                            ->label('Status Pegawai')
                            ->required()
                            ->options([
                                'aktif' => 'Aktif',
                                'non_aktif' => 'Non-Aktif',
                            ])
                            ->default('aktif')
                            ->native(false)
                            ->columnSpan(2),
                    ]),
            ]);
    }
}