<?php

namespace App\Filament\Resources\ItemTransactions\Pages;

use App\Filament\Resources\ItemTransactions\ItemTransactionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewItemTransaction extends ViewRecord
{
    protected static string $resource = ItemTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
