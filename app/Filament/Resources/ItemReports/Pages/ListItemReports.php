<?php

namespace App\Filament\Resources\ItemReports\Pages;

use App\Filament\Resources\ItemReports\ItemReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItemReports extends ListRecords
{
    protected static string $resource = ItemReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
