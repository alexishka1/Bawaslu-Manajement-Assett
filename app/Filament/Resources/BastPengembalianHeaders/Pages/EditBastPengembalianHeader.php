<?php

namespace App\Filament\Resources\BastPengembalianHeaders\Pages;

use App\Filament\Resources\BastPengembalianHeaders\BastPengembalianHeaderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBastPengembalianHeader extends EditRecord
{
    protected static string $resource = BastPengembalianHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
