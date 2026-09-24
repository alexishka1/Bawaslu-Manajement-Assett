<?php

namespace App\Filament\Resources\RefPejabats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RefPejabatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pejabat / Pihak Pertama')
                    ->description('Lengkapi data pejabat yang berwenang menandatangani BAST BMN.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nip')
                            ->label('NIP / Identitas')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->placeholder('Contoh: 197805122005011002')
                            ->columnSpan(1),

                        TextInput::make('nama')
                            ->label('Nama Lengkap & Gelar')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Drs. H. Suryanto, M.Si')
                            ->columnSpan(1),

                        TextInput::make('jabatan')
                            ->label('Jabatan Resmi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Kepala Sekretariat Bawaslu')
                            ->columnSpan(2),

                        Select::make('status')
                            ->label('Status Pejabat')
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
