<?php

namespace App\Filament\Resources\BastPemakaianHeaders\Pages;

use App\Filament\Resources\BastPemakaianHeaders\BastPemakaianHeaderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBastPemakaianHeader extends ViewRecord
{
    protected static string $resource = BastPemakaianHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
