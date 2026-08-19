<?php

namespace App\Filament\Resources\RefPegawais\Pages;

use App\Filament\Resources\RefPegawais\RefPegawaiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRefPegawai extends EditRecord
{
    protected static string $resource = RefPegawaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
