<?php

namespace App\Filament\Resources\ItemReports\Tables;

use App\Models\ItemReport;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ItemReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item.nama_barang')
                    ->label('Barang')
                    ->description(fn ($record) => $record->item?->kode_bmn ?? '-')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Pelapor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kondisi_aktual')
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

                TextColumn::make('status_validasi')
                    ->label('Status Validasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'divalidasi' => 'success',
                        'menunggu' => 'warning',
                        'ditolak' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->sortable(),

                ImageColumn::make('foto_bukti')
                    ->label('Foto Bukti')
                    ->circular()
                    ->size(40),

                TextColumn::make('created_at')
                    ->label('Dilaporkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status_validasi')
                    ->label('Filter Validasi')
                    ->options([
                        'menunggu' => 'Menunggu Validasi',
                        'divalidasi' => 'Divalidasi',
                        'ditolak' => 'Ditolak',
                    ]),

                SelectFilter::make('kondisi_aktual')
                    ->label('Filter Kondisi')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'terpakai' => 'Terpakai',
                        'servis' => 'Servis',
                        'rusak' => 'Rusak',
                        'hilang' => 'Hilang',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('validasi')
                    ->label('Validasi & Update Status')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Validasi Laporan Lapangan')
                    ->modalDescription('Apakah Anda yakin ingin memvalidasi laporan ini? Status aset di database akan otomatis diperbarui sesuai kondisi laporan staf.')
                    ->visible(fn (ItemReport $record) => $record->status_validasi === 'menunggu')
                    ->action(function (ItemReport $record) {
                        $record->update([
                            'status_validasi' => 'divalidasi',
                            'divalidasi_oleh' => auth()->id(),
                            'tanggal_validasi' => now(),
                        ]);

                        if ($record->item) {
                            $record->item->update([
                                'status' => $record->kondisi_aktual,
                            ]);
                        }

                        Notification::make()
                            ->title('Laporan Berhasil Divalidasi')
                            ->body('Status aset '.($record->item?->nama_barang ?? '').' kini menjadi '.ucfirst($record->kondisi_aktual))
                            ->success()
                            ->send();
                    }),
                Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Laporan Lapangan')
                    ->modalDescription('Apakah Anda yakin ingin menolak laporan ini? Status barang tidak akan diubah.')
                    ->visible(fn (ItemReport $record) => $record->status_validasi === 'menunggu')
                    ->action(function (ItemReport $record) {
                        $record->update([
                            'status_validasi' => 'ditolak',
                            'divalidasi_oleh' => auth()->id(),
                            'tanggal_validasi' => now(),
                        ]);

                        Notification::make()
                            ->title('Laporan Ditolak')
                            ->warning()
                            ->send();
                    }),
                DeleteAction::make(),
            ])
            ->headerActions([
                Action::make('export_csv')
                    ->label('Export Rekap CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(function () {
                        $reports = ItemReport::with(['item', 'user'])->latest()->get();
                        $filename = 'Rekap_Laporan_Aset_'.date('Ymd_His').'.csv';

                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => "attachment; filename=\"$filename\"",
                        ];

                        $callback = function () use ($reports) {
                            $handle = fopen('php://output', 'w');
                            fputcsv($handle, ['ID', 'Kode BMN', 'Nama Barang', 'Pelapor', 'Kondisi Dilaporkan', 'Status Validasi', 'Catatan', 'Tanggal Lapor']);

                            foreach ($reports as $report) {
                                fputcsv($handle, [
                                    $report->id,
                                    $report->item?->kode_bmn ?? '-',
                                    $report->item?->nama_barang ?? '-',
                                    $report->user?->name ?? '-',
                                    ucfirst($report->kondisi_aktual),
                                    strtoupper($report->status_validasi),
                                    $report->catatan ?? '-',
                                    $report->created_at->format('d/m/Y H:i'),
                                ]);
                            }
                            fclose($handle);
                        };

                        return response()->stream($callback, 200, $headers);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Laporan Lapangan')
            ->striped();
    }
}
