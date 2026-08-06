<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Tersedia', Item::where('status', 'tersedia')->count())
                ->description('Barang siap digunakan')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Terpakai', Item::where('status', 'terpakai')->count())
                ->description('Sedang dipinjam / digunakan')
                ->color('info')
                ->icon('heroicon-o-arrow-right-circle'),

            Stat::make('Servis', Item::where('status', 'servis')->count())
                ->description('Sedang dalam perbaikan')
                ->color('warning')
                ->icon('heroicon-o-wrench-screwdriver'),

            Stat::make('Rusak', Item::where('status', 'rusak')->count())
                ->description('Tidak dapat digunakan')
                ->color('danger')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
