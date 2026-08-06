<?php

namespace App\Filament\Resources\ItemTransactions;

use App\Filament\Resources\ItemTransactions\Pages\CreateItemTransaction;
use App\Filament\Resources\ItemTransactions\Pages\EditItemTransaction;
use App\Filament\Resources\ItemTransactions\Pages\ListItemTransactions;
use App\Filament\Resources\ItemTransactions\Pages\ViewItemTransaction;
use App\Filament\Resources\ItemTransactions\Schemas\ItemTransactionForm;
use App\Filament\Resources\ItemTransactions\Schemas\ItemTransactionInfolist;
use App\Filament\Resources\ItemTransactions\Tables\ItemTransactionsTable;
use App\Models\ItemTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ItemTransactionResource extends Resource
{
    protected static ?string $model = ItemTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Aset';

    protected static ?string $navigationLabel = 'Riwayat Peminjaman';

    protected static ?string $modelLabel = 'Transaksi Peminjaman';

    protected static ?string $pluralModelLabel = 'Riwayat Peminjaman';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nama_peminjam';

    public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return ItemTransactionForm::configure($schema);
    }

    public static function infolist(\Filament\Schemas\Schema $infolist): \Filament\Schemas\Schema
    {
        return ItemTransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemTransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItemTransactions::route('/'),
            'create' => CreateItemTransaction::route('/create'),
            'view' => ViewItemTransaction::route('/{record}'),
            'edit' => EditItemTransaction::route('/{record}/edit'),
        ];
    }
}

