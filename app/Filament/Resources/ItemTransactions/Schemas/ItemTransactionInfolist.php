<?php

namespace App\Filament\Resources\ItemTransactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ItemTransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('item.nama_barang')
                    ->label('Nama Barang'),
                TextEntry::make('item.kode_bmn')
                    ->label('Kode BMN'),
                TextEntry::make('nama_peminjam')
                    ->label('Nama Peminjam'),
                TextEntry::make('divisi')
                    ->label('Divisi'),
                TextEntry::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->date('d M Y'),
                TextEntry::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->date('d M Y')
                    ->placeholder('Belum dikembalikan'),
                TextEntry::make('catatan')
                    ->label('Catatan')
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
