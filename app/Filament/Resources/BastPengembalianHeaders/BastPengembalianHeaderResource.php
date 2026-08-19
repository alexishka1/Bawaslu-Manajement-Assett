<?php

namespace App\Filament\Resources\BastPengembalianHeaders;

use App\Filament\Resources\BastPengembalianHeaders\Pages\CreateBastPengembalianHeader;
use App\Filament\Resources\BastPengembalianHeaders\Pages\EditBastPengembalianHeader;
use App\Filament\Resources\BastPengembalianHeaders\Pages\ListBastPengembalianHeaders;
use App\Filament\Resources\BastPengembalianHeaders\Pages\ViewBastPengembalianHeader;
use App\Filament\Resources\BastPengembalianHeaders\Schemas\BastPengembalianHeaderForm;
use App\Filament\Resources\BastPengembalianHeaders\Schemas\BastPengembalianHeaderInfolist;
use App\Filament\Resources\BastPengembalianHeaders\Tables\BastPengembalianHeadersTable;
use App\Models\BastPengembalianHeader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BastPengembalianHeaderResource extends Resource
{
    protected static ?string $model = BastPengembalianHeader::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-uturn-left';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen BAST';

    protected static ?string $navigationLabel = 'BAST Pengembalian';

    protected static ?string $modelLabel = 'BAST Pengembalian';

    protected static ?string $pluralModelLabel = 'Daftar BAST Pengembalian';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nomor_bast_pengembalian';

    public static function form(Schema $schema): Schema
    {
        return BastPengembalianHeaderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BastPengembalianHeaderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BastPengembalianHeadersTable::configure($table);
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
            'index' => ListBastPengembalianHeaders::route('/'),
            'create' => CreateBastPengembalianHeader::route('/create'),
            'view' => ViewBastPengembalianHeader::route('/{record}'),
            'edit' => EditBastPengembalianHeader::route('/{record}/edit'),
        ];
    }
}