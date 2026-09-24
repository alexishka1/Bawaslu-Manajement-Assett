<?php

namespace App\Filament\Resources\ItemTransactions\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ItemTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item.nama_barang')
                    ->label('Nama Barang')
                    ->description(fn ($record) => $record->item?->kode_bmn ?? '-')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_peminjam')
                    ->label('Peminjam')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('divisi')
                    ->label('Divisi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal_pinjam')
                    ->label('Tgl Pinjam')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('tanggal_kembali')
                    ->label('Tgl Kembali')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('Belum Kembali'),

                TextColumn::make('status_kembali')
                    ->label('Status')
                    ->badge()
                    ->state(fn ($record): string => $record->tanggal_kembali ? 'Sudah Kembali' : 'Sedang Dipinjam')
                    ->color(fn (string $state): string => match ($state) {
                        'Sudah Kembali' => 'success',
                        'Sedang Dipinjam' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('belum_kembali')
                    ->label('Filter Status')
                    ->placeholder('Semua Transaksi')
                    ->trueLabel('Sedang Dipinjam')
                    ->falseLabel('Sudah Kembali')
                    ->queries(
                        true: fn ($query) => $query->whereNull('tanggal_kembali'),
                        false: fn ($query) => $query->whereNotNull('tanggal_kembali'),
                        blank: fn ($query) => $query,
                    )
                    ->native(false),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('cetak_bast')
                    ->label('Cetak BAST')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn ($record) => route('bast.download', $record))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Transaksi')
            ->striped();
    }
}
