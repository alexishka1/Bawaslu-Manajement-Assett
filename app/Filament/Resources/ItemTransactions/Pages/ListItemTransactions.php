<?php

namespace App\Filament\Resources\ItemTransactions\Pages;

use App\Filament\Resources\ItemTransactions\ItemTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItemTransactions extends ListRecords
{
    protected static string $resource = ItemTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
