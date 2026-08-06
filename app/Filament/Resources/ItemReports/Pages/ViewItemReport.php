<?php

namespace App\Filament\Resources\ItemReports\Pages;

use App\Filament\Resources\ItemReports\ItemReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewItemReport extends ViewRecord
{
    protected static string $resource = ItemReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
