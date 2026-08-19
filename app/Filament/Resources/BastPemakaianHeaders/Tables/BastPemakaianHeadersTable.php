<?php

namespace App\Filament\Resources\BastPemakaianHeaders\Tables;

use App\Models\BastPemakaianHeader;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BastPemakaianHeadersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_bast')
                    ->label('Nomor BAST')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->placeholder('DRAFT (Belum Terbit)'),

                TextColumn::make('jenis_bast')
                    ->label('Jenis BAST')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'BAST_PEMAKAIAN_KIB' => 'Pemakaian (KIB)',
                        'BAST_PEMAKAIAN_NON_KIB' => 'Pemakaian (Non-KIB)',
                        'BAST_PINJAM_PAKAI' => 'Pinjam Pakai',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('tanggal_bast')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('pihak_kedua_display')
                    ->label('Penerima (Pihak Kedua)')
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHas('pihakKedua', fn ($q) => $q->where('nama', 'like', "%{$search}%"))
                              ->orWhere('pihak_kedua_nama_manual', 'like', "%{$search}%");
                    }),

                TextColumn::make('details_count')
                    ->counts('details')
                    ->label('Jml Barang')
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),

                TextColumn::make('status_dokumen')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'final' => 'success',
                        'draft' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('jenis_bast')
                    ->label('Filter Jenis BAST')
                    ->options([
                        'BAST_PEMAKAIAN_KIB' => 'Pemakaian (KIB)',
                        'BAST_PEMAKAIAN_NON_KIB' => 'Pemakaian (Non-KIB)',
                        'BAST_PINJAM_PAKAI' => 'Pinjam Pakai',
                    ]),

                SelectFilter::make('status_dokumen')
                    ->label('Filter Status')
                    ->options([
                        'draft' => 'DRAFT',
                        'final' => 'FINAL',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('cetak_bast')
                    ->label('Cetak BAST PDF')
                    ->icon('heroicon-o-printer')
                    ->color('info')
                    ->url(fn (BastPemakaianHeader $record) => route('bast.pemakaian.download', $record))
                    ->openUrlInNewTab(),
                Action::make('finalize')
                    ->label('Terbitkan BAST')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Penerbitan BAST')
                    ->modalDescription('Apakah Anda yakin ingin menerbitkan dokumen BAST ini? Nomor resmi akan dibuat dan barang akan otomatis berstatus Terpakai.')
                    ->visible(fn (BastPemakaianHeader $record) => $record->status_dokumen === 'draft')
                    ->action(function (BastPemakaianHeader $record) {
                        $record->update(['status_dokumen' => 'final']);
                        Notification::make()
                            ->title('BAST Berhasil Diterbitkan')
                            ->body('Nomor dokumen: ' . $record->nomor_bast)
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Dokumen BAST Pemakaian')
            ->emptyStateDescription('Klik "+ Buat BAST" untuk membuat dokumen serah terima BMN baru.')
            ->striped();
    }
}