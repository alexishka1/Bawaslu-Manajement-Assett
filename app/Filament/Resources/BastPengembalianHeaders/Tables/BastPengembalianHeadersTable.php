<?php

namespace App\Filament\Resources\BastPengembalianHeaders\Tables;

use App\Models\BastPengembalianHeader;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BastPengembalianHeadersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_bast_pengembalian')
                    ->label('Nomor BAST')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->placeholder('DRAFT (Belum Terbit)'),

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('pihak_menyerahkan_display')
                    ->label('Yang Mengembalikan')
                    ->searchable(query: function ($query, string $search) {
                        $query->whereHas('pihakMenyerahkan', fn ($q) => $q->where('nama', 'like', "%{$search}%"))
                              ->orWhere('pihak_menyerahkan_nama_manual', 'like', "%{$search}%");
                    }),

                TextColumn::make('pihakMenerima.nama')
                    ->label('Pejabat Penerima')
                    ->searchable(),

                TextColumn::make('details_count')
                    ->counts('details')
                    ->label('Jml Barang')
                    ->badge()
                    ->color('success')
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
                    ->url(fn (BastPengembalianHeader $record) => route('bast.pengembalian.download', $record))
                    ->openUrlInNewTab(),
                Action::make('finalize')
                    ->label('Terbitkan BAST')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Penerbitan BAST Pengembalian')
                    ->modalDescription('Apakah Anda yakin ingin menerbitkan dokumen BAST Pengembalian ini? Nomor resmi akan diterbitkan dan barang yang dicentang akan kembali Tersedia.')
                    ->visible(fn (BastPengembalianHeader $record) => $record->status_dokumen === 'draft')
                    ->action(function (BastPengembalianHeader $record) {
                        $record->update(['status_dokumen' => 'final']);
                        Notification::make()
                            ->title('BAST Pengembalian Diterbitkan')
                            ->body('Nomor dokumen: ' . $record->nomor_bast_pengembalian)
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Dokumen BAST Pengembalian')
            ->emptyStateDescription('Klik "+ Buat BAST Pengembalian" saat barang BMN dikembalikan oleh pegawai.')
            ->striped();
    }
}