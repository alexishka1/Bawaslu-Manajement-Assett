<?php

namespace App\Filament\Resources\RefRuangans\Pages;

use App\Filament\Resources\RefRuangans\RefRuanganResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRefRuangan extends ViewRecord
{
    protected static string $resource = RefRuanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cetak_dir')
                ->label('Cetak Lembar DIR (PDF)')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->url(fn () => route('ruangan.download-dir', $this->record))
                ->openUrlInNewTab(),

            Action::make('unduh_qr')
                ->label('Unduh QR Pintu')
                ->icon('heroicon-o-qr-code')
                ->color('info')
                ->url(fn () => route('ruangan.download-qr', $this->record))
                ->openUrlInNewTab(),

            EditAction::make(),
        ];
    }
}
