<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Resources\Items\ItemResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('printSheet')
                ->label('Cetak Lembar QR Code')
                ->icon('heroicon-o-printer')
                ->color('warning')
                ->url(route('qrcode.print-sheet'))
                ->openUrlInNewTab(),
            CreateAction::make(),
        ];
    }
}
