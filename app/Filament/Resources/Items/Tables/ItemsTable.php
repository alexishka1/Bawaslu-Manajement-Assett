<?php

namespace App\Filament\Resources\Items\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_bmn')
                    ->label('Kode BMN')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),

                ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=BMN&background=6366f1&color=fff')
                    ->size(40),

                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Elektronik' => 'info',
                        'ATK' => 'gray',
                        'Kendaraan' => 'warning',
                        'Mebel' => 'success',
                        'Arsip' => 'primary',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('lokasi_simpan')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable()
                    ->limit(25),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'tersedia' => 'success',
                        'terpakai' => 'info',
                        'servis' => 'warning',
                        'rusak' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'terpakai' => 'Terpakai',
                        'servis' => 'Servis',
                        'rusak' => 'Rusak',
                    ])
                    ->native(false),

                SelectFilter::make('kategori')
                    ->label('Filter Kategori')
                    ->options([
                        'Elektronik' => 'Elektronik',
                        'ATK' => 'ATK',
                        'Kendaraan' => 'Kendaraan',
                        'Mebel' => 'Mebel',
                        'Arsip' => 'Arsip',
                    ])
                    ->native(false),
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
            ->emptyStateHeading('Belum Ada Barang')
            ->emptyStateDescription('Klik tombol "Tambah Barang" untuk menambahkan data barang BMN baru.')
            ->striped();
    }
}
