<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('nip')
                    ->label('NIP')
                    ->placeholder('-')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->placeholder('-')
                    ->description(fn (User $record) => $record->unit_kerja)
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Peran (Role)')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'staff' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->sortable(),
                TextColumn::make('is_verified')
                    ->label('Status Akun')
                    ->badge()
                    ->state(fn (User $record): string => $record->isAdmin() || $record->is_verified ? 'Terverifikasi' : 'Menunggu Verifikasi')
                    ->color(fn (string $state): string => match ($state) {
                        'Terverifikasi' => 'success',
                        'Menunggu Verifikasi' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Didaftarkan')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Filter Peran')
                    ->options([
                        'admin' => 'ADMIN',
                        'staff' => 'STAFF',
                    ]),
                SelectFilter::make('is_verified')
                    ->label('Status Verifikasi')
                    ->options([
                        '1' => 'Terverifikasi',
                        '0' => 'Menunggu Verifikasi',
                    ]),
            ])
            ->recordActions([
                Action::make('verify')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (User $record): bool => $record->isStaff() && ! $record->is_verified)
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Akun Staf')
                    ->modalDescription(fn (User $record) => "Setujui akun {$record->name} agar dapat login ke portal staf Bawaslu?")
                    ->action(function (User $record) {
                        $record->update([
                            'is_verified' => true,
                            'verified_at' => now(),
                            'verified_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Staf Berhasil Diverifikasi')
                            ->body("Akun staf {$record->name} telah aktif dan dapat login.")
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make()
                    ->hidden(fn (User $record): bool => $record->id === auth()->id()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Pengguna')
            ->striped();
    }
}
