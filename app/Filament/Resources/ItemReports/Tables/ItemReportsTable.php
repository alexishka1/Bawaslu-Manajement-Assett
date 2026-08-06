<?php

namespace App\Filament\Resources\ItemReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;

class ItemReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('item.nama_barang')
                    ->label('Barang')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('kondisi_aktual')
                    ->label('Kondisi Laporan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tersedia' => 'success',
                        'terpakai' => 'info',
                        'servis' => 'warning',
                        'rusak', 'hilang' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                \Filament\Tables\Columns\ImageColumn::make('foto_bukti')
                    ->label('Foto Bukti')
                    ->square(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Dilaporkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\Action::make('update_status')
                    ->label('Update Status Asli')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Update Status')
                    ->modalDescription('Apakah Anda yakin ingin memperbarui status asli barang di database sesuai dengan laporan lapangan ini?')
                    ->action(function (\App\Models\ItemReport $record) {
                        $record->item->update([
                            'status' => $record->kondisi_aktual
                        ]);
                        \Filament\Notifications\Notification::make()
                            ->title('Status barang berhasil diperbarui')
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
