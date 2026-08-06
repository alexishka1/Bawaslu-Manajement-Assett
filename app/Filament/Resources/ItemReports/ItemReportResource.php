<?php

namespace App\Filament\Resources\ItemReports;

use App\Filament\Resources\ItemReports\Pages\CreateItemReport;
use App\Filament\Resources\ItemReports\Pages\EditItemReport;
use App\Filament\Resources\ItemReports\Pages\ListItemReports;
use App\Filament\Resources\ItemReports\Pages\ViewItemReport;
use App\Filament\Resources\ItemReports\Schemas\ItemReportForm;
use App\Filament\Resources\ItemReports\Schemas\ItemReportInfolist;
use App\Filament\Resources\ItemReports\Tables\ItemReportsTable;
use App\Models\ItemReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ItemReportResource extends Resource
{
    protected static ?string $model = ItemReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Laporan Lapangan';

    protected static ?string $modelLabel = 'Laporan Lapangan';

    protected static ?string $pluralModelLabel = 'Laporan Lapangan';

    protected static string|\UnitEnum|null $navigationGroup = 'Audit & Log';

    public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return ItemReportForm::configure($schema);
    }

    public static function infolist(\Filament\Schemas\Schema $infolist): \Filament\Schemas\Schema
    {
        return ItemReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemReportsTable::configure($table);
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
            'index' => ListItemReports::route('/'),
            'view' => ViewItemReport::route('/{record}'),
        ];
    }
}

