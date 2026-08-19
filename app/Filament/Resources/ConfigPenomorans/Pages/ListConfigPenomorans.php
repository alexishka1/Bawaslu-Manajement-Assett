<?php

namespace App\Filament\Resources\ConfigPenomorans\Pages;

use App\Filament\Resources\ConfigPenomorans\ConfigPenomoranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConfigPenomorans extends ListRecords
{
    protected static string $resource = ConfigPenomoranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
