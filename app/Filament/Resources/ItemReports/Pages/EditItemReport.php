<?php

namespace App\Filament\Resources\ItemReports\Pages;

use App\Filament\Resources\ItemReports\ItemReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditItemReport extends EditRecord
{
    protected static string $resource = ItemReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
