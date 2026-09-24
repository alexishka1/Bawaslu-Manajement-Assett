<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\ItemReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalItems = Item::count();
        $availableItems = Item::where('status', 'tersedia')->count();
        $borrowedItems = Item::where('status', 'terpakai')->count();
        $damagedItems = Item::whereIn('status', ['rusak', 'servis'])->count();
        $pendingReports = ItemReport::where('status_validasi', 'menunggu')->count();

        return [
            Stat::make('Total Aset BMN', $totalItems)
                ->description('Total barang terdaftar')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('primary'),
            Stat::make('Aset Siap Pakai', $availableItems)
                ->description('Kondisi prima & tersedia')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
            Stat::make('Sedang Digunakan', $borrowedItems)
                ->description('Barang dalam pemakaian aktif')
                ->descriptionIcon('heroicon-m-arrow-right-circle')
                ->color('warning'),
            Stat::make('Laporan Menunggu Validasi', $pendingReports)
                ->description($pendingReports > 0 ? 'Perlu tindakan validasi segera' : 'Semua laporan telah diproses')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color($pendingReports > 0 ? 'danger' : 'success'),
        ];
    }
}
