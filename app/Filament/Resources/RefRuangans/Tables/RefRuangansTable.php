<?php

namespace App\Filament\Resources\RefRuangans\Tables;

use App\Models\RefRuangan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RefRuangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_ruangan')
                    ->label('Kode Ruangan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->fontFamily('mono')
                    ->color('primary'),

                TextColumn::make('nama_ruangan')
                    ->label('Nama Ruangan')
                    ->description(fn (RefRuangan $record) => $record->gedung ?? 'Gedung Utama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('lantai')
                    ->label('Lantai')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Lantai 1' => 'info',
                        'Lantai 2' => 'success',
                        'Lantai 3' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('penanggung_jawab')
                    ->label('Penanggung Jawab')
                    ->description(fn (RefRuangan $record) => $record->nip_penanggung_jawab ? 'NIP. '.$record->nip_penanggung_jawab : '-')
                    ->searchable(),

                TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Total Aset BMN')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
            ])
            ->defaultSort('kode_ruangan')
            ->filters([
                SelectFilter::make('lantai')
                    ->label('Filter Lantai')
                    ->options([
                        'Lantai 1' => 'Lantai 1',
                        'Lantai 2' => 'Lantai 2',
                        'Lantai 3' => 'Lantai 3',
                        'Basement' => 'Basement',
                    ]),
            ])
            ->recordActions([
                Action::make('cetak_dir')
                    ->label('Cetak DIR (PDF)')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn (RefRuangan $record) => route('ruangan.download-dir', $record))
                    ->openUrlInNewTab(),

                Action::make('unduh_qr')
                    ->label('QR Pintu')
                    ->icon('heroicon-o-qr-code')
                    ->color('info')
                    ->url(fn (RefRuangan $record) => route('ruangan.download-qr', $record))
                    ->openUrlInNewTab(),

                Action::make('inventaris_live')
                    ->label('Live Scan')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (RefRuangan $record) => route('ruangan.show', $record->kode_ruangan))
                    ->openUrlInNewTab(),

                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Data Ruangan')
            ->emptyStateDescription('Tambahkan data ruangan kantor untuk mulai melacak penempatan aset BMN.')
            ->striped();
    }
}
