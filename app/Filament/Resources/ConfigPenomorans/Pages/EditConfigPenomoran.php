<?php

namespace App\Filament\Resources\ConfigPenomorans\Pages;

use App\Filament\Resources\ConfigPenomorans\ConfigPenomoranResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditConfigPenomoran extends EditRecord
{
    protected static string $resource = ConfigPenomoranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
