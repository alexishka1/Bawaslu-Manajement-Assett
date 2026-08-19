<?php

namespace App\Filament\Resources\RefPejabats\Pages;

use App\Filament\Resources\RefPejabats\RefPejabatResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRefPejabat extends ViewRecord
{
    protected static string $resource = RefPejabatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
