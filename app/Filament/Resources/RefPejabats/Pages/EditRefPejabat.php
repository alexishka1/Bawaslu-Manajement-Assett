<?php

namespace App\Filament\Resources\RefPejabats\Pages;

use App\Filament\Resources\RefPejabats\RefPejabatResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRefPejabat extends EditRecord
{
    protected static string $resource = RefPejabatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
