<?php

namespace App\Filament\Resources\ConfigTemplates\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfigTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Template Dokumen BAST')
                    ->description('Tentukan template Blade view untuk pencetakan dokumen PDF BAST.')
                    ->columns(2)
                    ->schema([
                        Select::make('jenis_dokumen')
                            ->label('Jenis Dokumen BAST')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->options([
                                'BAST_PEMAKAIAN_KIB' => 'BAST Pemakaian (KIB)',
                                'BAST_PEMAKAIAN_NON_KIB' => 'BAST Pemakaian (Non-KIB)',
                                'BAST_PINJAM_PAKAI' => 'BAST Pinjam Pakai',
                                'BAST_PENGEMBALIAN' => 'BAST Pengembalian',
                            ])
                            ->native(false)
                            ->columnSpan(1),

                        TextInput::make('nama_template')
                            ->label('Nama Template')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Template Resmi BAST Pemakaian KIB')
                            ->columnSpan(1),

                        TextInput::make('blade_view')
                            ->label('Blade View Path')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: pdf.bast-pemakaian')
                            ->helperText('Nama view Blade yang tersimpan di resources/views (contoh: pdf.bast-pemakaian).')
                            ->columnSpan(2),

                        Textarea::make('keterangan')
                            ->label('Keterangan / Catatan')
                            ->nullable()
                            ->columnSpan(2),
                    ]),
            ]);
    }
}
