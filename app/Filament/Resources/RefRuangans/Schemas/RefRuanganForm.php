<?php

namespace App\Filament\Resources\RefRuangans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RefRuanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Ruangan Kantor')
                    ->description('Data referensi ruangan dan penempatan aset BMN.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('kode_ruangan')
                            ->label('Kode Ruangan')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->placeholder('Contoh: R-101, R-201, GDG-01')
                            ->columnSpan(1),

                        TextInput::make('nama_ruangan')
                            ->label('Nama Ruangan')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Ruang Sidang Sengketa, Ruang Ketua')
                            ->columnSpan(1),

                        Select::make('lantai')
                            ->label('Lantai / Tingkat')
                            ->required()
                            ->options([
                                'Lantai 1' => 'Lantai 1',
                                'Lantai 2' => 'Lantai 2',
                                'Lantai 3' => 'Lantai 3',
                                'Basement' => 'Basement',
                                'Lainnya' => 'Lainnya / Luar Gedung',
                            ])
                            ->default('Lantai 1')
                            ->native(false)
                            ->columnSpan(1),

                        TextInput::make('gedung')
                            ->label('Gedung Kantor')
                            ->default('Gedung Kantor Bawaslu')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(1),
                    ]),

                Section::make('Penanggung Jawab Ruangan')
                    ->description('Pejabat / Pegawai yang bertanggung jawab atas aset di ruangan ini.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('penanggung_jawab')
                            ->label('Nama Penanggung Jawab (PIC)')
                            ->placeholder('Contoh: Budi Santoso, S.H.')
                            ->maxLength(100)
                            ->columnSpan(1),

                        TextInput::make('nip_penanggung_jawab')
                            ->label('NIP Penanggung Jawab')
                            ->placeholder('Contoh: 198001012005011001')
                            ->maxLength(30)
                            ->columnSpan(1),

                        Textarea::make('keterangan')
                            ->label('Keterangan / Catatan Ruangan')
                            ->placeholder('Catatan khusus fungsi ruangan atau peruntukan aset')
                            ->columnSpan(2),
                    ]),
            ]);
    }
}
