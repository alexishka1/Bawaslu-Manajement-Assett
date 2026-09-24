<?php

namespace App\Filament\Widgets;

use App\Models\ItemTransaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactionsWidget extends BaseWidget
{
    protected static ?string $heading = 'Transaksi Peminjaman Terbaru';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 10;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ItemTransaction::query()->latest('tanggal_pinjam')->limit(8)
            )
            ->columns([
                TextColumn::make('item.nama_barang')
                    ->label('Barang')
                    ->description(fn ($record) => $record->item?->kode_bmn ?? '-'),
                TextColumn::make('nama_peminjam')
                    ->label('Peminjam')
                    ->weight('bold'),
                TextColumn::make('divisi')
                    ->label('Divisi'),
                TextColumn::make('tanggal_pinjam')
                    ->label('Tgl Pinjam')
                    ->date('d M Y'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->state(fn ($record): string => $record->tanggal_kembali ? 'Dikembalikan' : 'Dipinjam')
                    ->color(fn (string $state): string => match ($state) {
                        'Dikembalikan' => 'success',
                        'Dipinjam' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->paginated(false);
    }
}
