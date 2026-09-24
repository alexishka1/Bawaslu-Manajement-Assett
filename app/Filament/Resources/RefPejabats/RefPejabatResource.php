<?php

namespace App\Filament\Resources\RefPejabats;

use App\Filament\Resources\RefPejabats\Pages\CreateRefPejabat;
use App\Filament\Resources\RefPejabats\Pages\EditRefPejabat;
use App\Filament\Resources\RefPejabats\Pages\ListRefPejabats;
use App\Filament\Resources\RefPejabats\Pages\ViewRefPejabat;
use App\Filament\Resources\RefPejabats\Schemas\RefPejabatForm;
use App\Filament\Resources\RefPejabats\Schemas\RefPejabatInfolist;
use App\Filament\Resources\RefPejabats\Tables\RefPejabatsTable;
use App\Models\RefPejabat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class RefPejabatResource extends Resource
{
    protected static ?string $model = RefPejabat::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static string|\UnitEnum|null $navigationGroup = 'Data Referensi';

    protected static ?string $navigationLabel = 'Master Pejabat';

    protected static ?string $modelLabel = 'Pejabat';

    protected static ?string $pluralModelLabel = 'Daftar Pejabat';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return RefPejabatForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RefPejabatInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RefPejabatsTable::configure($table);
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
            'index' => ListRefPejabats::route('/'),
            'create' => CreateRefPejabat::route('/create'),
            'view' => ViewRefPejabat::route('/{record}'),
            'edit' => EditRefPejabat::route('/{record}/edit'),
        ];
    }
}
