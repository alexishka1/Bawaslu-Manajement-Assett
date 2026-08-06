<?php

namespace App\Filament\Resources\ItemTransactions\Pages;

use App\Filament\Resources\ItemTransactions\ItemTransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditItemTransaction extends EditRecord
{
    protected static string $resource = ItemTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
