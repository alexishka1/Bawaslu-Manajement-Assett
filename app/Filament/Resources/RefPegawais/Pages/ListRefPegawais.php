<?php

namespace App\Filament\Resources\RefPegawais\Pages;

use App\Filament\Resources\RefPegawais\RefPegawaiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRefPegawais extends ListRecords
{
    protected static string $resource = RefPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
