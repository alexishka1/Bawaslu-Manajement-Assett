<?php

namespace App\Filament\Resources\RefPegawais\Pages;

use App\Filament\Resources\RefPegawais\RefPegawaiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRefPegawai extends ViewRecord
{
    protected static string $resource = RefPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
