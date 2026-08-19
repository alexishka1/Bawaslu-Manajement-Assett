<?php

namespace App\Filament\Resources\ConfigPenomorans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ConfigPenomoransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jenis_dokumen')
                    ->label('Jenis Dokumen')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('format_nomor')
                    ->label('Format Nomor')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('counter_terakhir')
                    ->label('Counter Terakhir')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('tahun_berjalan')
                    ->label('Tahun')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tahun_berjalan')
                    ->label('Filter Tahun')
                    ->options(function () {
                        $currentYear = (int) date('Y');
                        return [
                            $currentYear => (string) $currentYear,
                            $currentYear - 1 => (string) ($currentYear - 1),
                        ];
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Format Penomoran')
            ->striped();
    }
}