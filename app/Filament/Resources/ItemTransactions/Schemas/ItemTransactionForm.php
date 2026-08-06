<?php

namespace App\Filament\Resources\ItemTransactions\Schemas;

use Filament\Schemas\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ItemTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Transaksi')
                    ->description('Pilih barang dan detail peminjam.')
                    ->columns(2)
                    ->schema([
                        Select::make('item_id')
                            ->label('Barang (BMN)')
                            ->relationship('item', 'nama_barang', modifyQueryUsing: fn (Builder $query) => $query->where('status', '!=', 'rusak'))
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->kode_bmn} - {$record->nama_barang}")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('nama_peminjam')
                            ->label('Nama Peminjam')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Budi Santoso')
                            ->columnSpan(1),

                        TextInput::make('divisi')
                            ->label('Divisi / Bagian')
                            ->required()
                            ->maxLength(255)
                            ->datalist([
                                'Pimpinan',
                                'Sekretariat',
                                'Divisi SDM dan Organisasi',
                                'Divisi Pengawasan',
                                'Divisi Hukum dan Penyelesaian Sengketa',
                                'Divisi Penanganan Pelanggaran',
                            ])
                            ->placeholder('Contoh: Divisi SDM')
                            ->columnSpan(1),
                    ]),

                Section::make('Waktu & Catatan')
                    ->description('Tentukan tanggal pinjam dan kembali.')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('tanggal_pinjam')
                            ->label('Tanggal Pinjam')
                            ->required()
                            ->default(now())
                            ->columnSpan(1),

                        DatePicker::make('tanggal_kembali')
                            ->label('Tanggal Kembali')
                            ->placeholder('Pilih jika sudah dikembalikan')
                            ->columnSpan(1),

                        Textarea::make('catatan')
                            ->label('Catatan Tambahan')
                            ->maxLength(65535)
                            ->columnSpan(2),
                    ]),
            ]);
    }
}


