<?php

namespace App\Filament\Resources\RefRuangans;

use App\Filament\Resources\RefRuangans\Pages\CreateRefRuangan;
use App\Filament\Resources\RefRuangans\Pages\EditRefRuangan;
use App\Filament\Resources\RefRuangans\Pages\ListRefRuangans;
use App\Filament\Resources\RefRuangans\Pages\ViewRefRuangan;
use App\Filament\Resources\RefRuangans\Schemas\RefRuanganForm;
use App\Filament\Resources\RefRuangans\Schemas\RefRuanganInfolist;
use App\Filament\Resources\RefRuangans\Tables\RefRuangansTable;
use App\Models\RefRuangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class RefRuanganResource extends Resource
{
    protected static ?string $model = RefRuangan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home-modern';

    protected static string|\UnitEnum|null $navigationGroup = 'Data Referensi';

    protected static ?string $navigationLabel = 'Master Ruangan (DIR)';

    protected static ?string $modelLabel = 'Ruangan';

    protected static ?string $pluralModelLabel = 'Daftar Ruangan';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'nama_ruangan';

    public static function form(Schema $schema): Schema
    {
        return RefRuanganForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RefRuanganInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RefRuangansTable::configure($table);
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
            'index' => ListRefRuangans::route('/'),
            'create' => CreateRefRuangan::route('/create'),
            'view' => ViewRefRuangan::route('/{record}'),
            'edit' => EditRefRuangan::route('/{record}/edit'),
        ];
    }
}
