<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\ItemTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalItems = Item::count();
        $damagedItems = Item::whereIn('status', ['rusak', 'servis'])->count();
        $borrowedItems = ItemTransaction::whereNull('tanggal_kembali')->count();

        return [
            Stat::make('Total Aset Keseluruhan', $totalItems)
                ->description('Jumlah seluruh barang yang terdaftar')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success'),
            Stat::make('Aset Bermasalah/Rusak', $damagedItems)
                ->description('Kondisi Rusak Ringan/Berat')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($damagedItems > 0 ? 'danger' : 'success'),
            Stat::make('Aset Sedang Dipinjam', $borrowedItems)
                ->description('Barang yang belum dikembalikan')
                ->descriptionIcon('heroicon-m-arrow-right-circle')
                ->color('warning'),
        ];
    }
}
