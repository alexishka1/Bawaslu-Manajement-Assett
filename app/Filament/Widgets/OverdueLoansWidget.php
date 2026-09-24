<?php

namespace App\Filament\Widgets;

use App\Models\ItemTransaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OverdueLoansWidget extends BaseWidget
{
    protected static ?string $heading = '⚠️ Barang Belum Dikembalikan > 7 Hari';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 11;

    // Sembunyikan widget kalau tidak ada data telat (dashboard tidak berisik)
    public static function canView(): bool
    {
        return ItemTransaction::whereNull('tanggal_kembali')
            ->where('tanggal_pinjam', '<=', now()->subDays(7))
            ->exists();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ItemTransaction::query()
                    ->whereNull('tanggal_kembali')
                    ->where('tanggal_pinjam', '<=', now()->subDays(7))
                    ->orderBy('tanggal_pinjam')
            )
            ->columns([
                TextColumn::make('item.nama_barang')->label('Barang'),
                TextColumn::make('nama_peminjam')->label('Peminjam')->weight('bold'),
                TextColumn::make('divisi')->label('Divisi'),
                TextColumn::make('tanggal_pinjam')
                    ->label('Tgl Pinjam')
                    ->date('d M Y')
                    ->color('danger'),
                TextColumn::make('hari_terlambat')
                    ->label('Sudah Berapa Hari')
                    ->state(fn ($record) => now()->diffInDays($record->tanggal_pinjam) . ' hari')
                    ->badge()
                    ->color('danger'),
            ])
            ->paginated(false);
    }
}
