<?php

namespace App\Filament\Resources\BastPemakaianHeaders;

use App\Filament\Resources\BastPemakaianHeaders\Pages\CreateBastPemakaianHeader;
use App\Filament\Resources\BastPemakaianHeaders\Pages\EditBastPemakaianHeader;
use App\Filament\Resources\BastPemakaianHeaders\Pages\ListBastPemakaianHeaders;
use App\Filament\Resources\BastPemakaianHeaders\Pages\ViewBastPemakaianHeader;
use App\Filament\Resources\BastPemakaianHeaders\Schemas\BastPemakaianHeaderForm;
use App\Filament\Resources\BastPemakaianHeaders\Schemas\BastPemakaianHeaderInfolist;
use App\Filament\Resources\BastPemakaianHeaders\Tables\BastPemakaianHeadersTable;
use App\Models\BastPemakaianHeader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BastPemakaianHeaderResource extends Resource
{
    protected static ?string $model = BastPemakaianHeader::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen BAST';

    protected static ?string $navigationLabel = 'BAST Pemakaian';

    protected static ?string $modelLabel = 'BAST Pemakaian';

    protected static ?string $pluralModelLabel = 'Daftar BAST Pemakaian';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nomor_bast';

    public static function form(Schema $schema): Schema
    {
        return BastPemakaianHeaderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BastPemakaianHeaderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BastPemakaianHeadersTable::configure($table);
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
            'index' => ListBastPemakaianHeaders::route('/'),
            'create' => CreateBastPemakaianHeader::route('/create'),
            'view' => ViewBastPemakaianHeader::route('/{record}'),
            'edit' => EditBastPemakaianHeader::route('/{record}/edit'),
        ];
    }
}
