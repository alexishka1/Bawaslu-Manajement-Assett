<?php

namespace App\Filament\Resources\RefRuangans\Pages;

use App\Filament\Resources\RefRuangans\RefRuanganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRefRuangans extends ListRecords
{
    protected static string $resource = RefRuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
