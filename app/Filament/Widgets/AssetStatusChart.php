<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use Filament\Widgets\ChartWidget;

class AssetStatusChart extends ChartWidget
{
    protected ?string $heading = 'Distribusi Kondisi & Status Aset BMN';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $data = [
            'tersedia' => Item::where('status', 'tersedia')->count(),
            'terpakai' => Item::where('status', 'terpakai')->count(),
            'servis'   => Item::where('status', 'servis')->count(),
            'rusak'    => Item::where('status', 'rusak')->count(),
        ];

        return [
            'datasets' => [[
                'data' => array_values($data),
                'backgroundColor' => [
                    '#15803D', // tersedia - hijau
                    '#D97706', // terpakai - emas
                    '#1D4ED8', // servis - biru
                    '#B91C1C', // rusak - merah
                ],
            ]],
            'labels' => ['Tersedia', 'Terpakai', 'Servis/Perbaikan', 'Rusak'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
