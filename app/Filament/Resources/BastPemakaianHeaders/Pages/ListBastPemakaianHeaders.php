<?php

namespace App\Filament\Resources\BastPemakaianHeaders\Pages;

use App\Filament\Resources\BastPemakaianHeaders\BastPemakaianHeaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBastPemakaianHeaders extends ListRecords
{
    protected static string $resource = BastPemakaianHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
