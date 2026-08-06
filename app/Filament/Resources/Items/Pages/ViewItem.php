<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Resources\Items\ItemResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewItem extends ViewRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('cetak_qrcode')
                ->label('Cetak QR Code')
                ->icon('heroicon-o-qr-code')
                ->color('info')
                ->url(fn () => route('qrcode.download', $this->record))
                ->openUrlInNewTab(),
            EditAction::make(),
        ];
    }
}
