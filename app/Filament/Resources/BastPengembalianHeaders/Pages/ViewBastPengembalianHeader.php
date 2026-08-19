<?php

namespace App\Filament\Resources\BastPengembalianHeaders\Pages;

use App\Filament\Resources\BastPengembalianHeaders\BastPengembalianHeaderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBastPengembalianHeader extends ViewRecord
{
    protected static string $resource = BastPengembalianHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
