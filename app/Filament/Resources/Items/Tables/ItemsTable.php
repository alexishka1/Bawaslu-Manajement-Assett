<?php

namespace App\Filament\Resources\Items\Tables;

use App\Models\Item;
use App\Models\RefRuangan;
use App\Services\RuanganService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
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
                    ->label('Lokasi Detail')
                    ->searchable()
                    ->sortable()
                    ->limit(25),

                TextColumn::make('ruangan.nama_ruangan')
                    ->label('Ruangan')
                    ->description(fn (Item $record) => $record->ruangan?->lantai ?? '-')
                    ->placeholder('Belum Ditentukan')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

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

                SelectFilter::make('ref_ruangan_id')
                    ->label('Filter Ruangan')
                    ->relationship('ruangan', 'nama_ruangan')
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('cetak_qr')
                    ->label('Unduh QR')
                    ->icon('heroicon-o-qr-code')
                    ->color('info')
                    ->url(fn (Item $record) => route('qrcode.download', $record))
                    ->openUrlInNewTab(),
                Action::make('mutasi_ruangan')
                    ->label('Pindah Ruang')
                    ->icon('heroicon-o-arrows-right-left')
                    ->color('warning')
                    ->schema([
                        Select::make('ref_ruangan_id')
                            ->label('Pilih Ruangan Tujuan')
                            ->options(fn () => RefRuangan::pluck('nama_ruangan', 'id'))
                            ->required()
                            ->searchable(),
                        TextInput::make('alasan')
                            ->label('Alasan Pemindahan')
                            ->placeholder('Misal: Kebutuhan sidang sengketa / penataan ulang')
                            ->required(),
                    ])
                    ->action(function (Item $record, array $data) {
                        $ruangan = RefRuangan::findOrFail($data['ref_ruangan_id']);
                        app(RuanganService::class)->mutasiItem($record, $ruangan, $data['alasan']);

                        Notification::make()
                            ->title('Aset Berhasil Dipindahkan')
                            ->body("Aset {$record->nama_barang} kini tercatat di {$ruangan->nama_ruangan}.")
                            ->success()
                            ->send();
                    }),
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
