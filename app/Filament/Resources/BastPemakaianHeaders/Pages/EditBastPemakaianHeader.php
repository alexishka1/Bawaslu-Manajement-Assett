<?php

namespace App\Filament\Resources\BastPemakaianHeaders\Pages;

use App\Filament\Resources\BastPemakaianHeaders\BastPemakaianHeaderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBastPemakaianHeader extends EditRecord
{
    protected static string $resource = BastPemakaianHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
