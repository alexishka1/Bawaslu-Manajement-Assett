<?php

namespace App\Filament\Widgets;

use App\Models\ItemTransaction;
use Filament\Widgets\ChartWidget;

class TopBorrowedItemsChart extends ChartWidget
{
    protected ?string $heading = '5 Barang Paling Sering Dipinjam';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $top = ItemTransaction::query()
            ->selectRaw('item_id, COUNT(*) as total')
            ->groupBy('item_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('item')
            ->get();

        return [
            'datasets' => [[
                'label' => 'Kali Dipinjam',
                'data' => $top->pluck('total')->toArray(),
                'backgroundColor' => '#D97706',
                'borderRadius' => 6,
            ]],
            'labels' => $top->pluck('item.nama_barang')->map(
                fn ($nama) => $nama ?? 'Barang Dihapus'
            )->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
