<?php

namespace App\Filament\Resources\ConfigTemplates\Pages;

use App\Filament\Resources\ConfigTemplates\ConfigTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditConfigTemplate extends EditRecord
{
    protected static string $resource = ConfigTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
