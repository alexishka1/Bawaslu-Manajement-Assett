<?php

namespace App\Filament\Resources\BastPengembalianHeaders\Pages;

use App\Filament\Resources\BastPengembalianHeaders\BastPengembalianHeaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBastPengembalianHeaders extends ListRecords
{
    protected static string $resource = BastPengembalianHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
