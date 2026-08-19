<?php

namespace App\Filament\Resources\RefPejabats\Pages;

use App\Filament\Resources\RefPejabats\RefPejabatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRefPejabats extends ListRecords
{
    protected static string $resource = RefPejabatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
