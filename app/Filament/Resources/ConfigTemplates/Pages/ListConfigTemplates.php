<?php

namespace App\Filament\Resources\ConfigTemplates\Pages;

use App\Filament\Resources\ConfigTemplates\ConfigTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConfigTemplates extends ListRecords
{
    protected static string $resource = ConfigTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
