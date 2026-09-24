<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use Filament\Widgets\ChartWidget;

class KategoriDistributionChart extends ChartWidget
{
    protected ?string $heading = 'Sebaran Aset per Kategori';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $kategori = ['Elektronik', 'ATK', 'Kendaraan', 'Mebel', 'Arsip'];

        $counts = collect($kategori)->map(
            fn ($k) => Item::where('kategori', $k)->count()
        );

        return [
            'datasets' => [[
                'label' => 'Jumlah Barang',
                'data' => $counts->toArray(),
                'backgroundColor' => '#B91C1C',
                'borderRadius' => 6,
            ]],
            'labels' => $kategori,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
