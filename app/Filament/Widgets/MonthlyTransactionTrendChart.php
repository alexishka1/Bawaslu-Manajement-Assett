<?php

namespace App\Filament\Widgets;

use App\Models\ItemTransaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MonthlyTransactionTrendChart extends ChartWidget
{
    protected ?string $heading = 'Tren Peminjaman Barang (6 Bulan Terakhir)';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        $counts = $months->map(function (Carbon $month) {
            return ItemTransaction::whereYear('tanggal_pinjam', $month->year)
                ->whereMonth('tanggal_pinjam', $month->month)
                ->count();
        });

        return [
            'datasets' => [[
                'label' => 'Transaksi Peminjaman',
                'data' => $counts->toArray(),
                'borderColor' => '#B91C1C',
                'backgroundColor' => 'rgba(185, 28, 28, 0.1)',
                'fill' => true,
                'tension' => 0.3,
            ]],
            'labels' => $months->map(fn ($m) => $m->translatedFormat('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
