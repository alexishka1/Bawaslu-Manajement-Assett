<?php

namespace App\Filament\Resources\RefRuangans\Pages;

use App\Filament\Resources\RefRuangans\RefRuanganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRefRuangan extends EditRecord
{
    protected static string $resource = RefRuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
