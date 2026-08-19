<?php

namespace App\Filament\Resources\ConfigPenomorans;

use App\Filament\Resources\ConfigPenomorans\Pages\CreateConfigPenomoran;
use App\Filament\Resources\ConfigPenomorans\Pages\EditConfigPenomoran;
use App\Filament\Resources\ConfigPenomorans\Pages\ListConfigPenomorans;
use App\Filament\Resources\ConfigPenomorans\Schemas\ConfigPenomoranForm;
use App\Filament\Resources\ConfigPenomorans\Tables\ConfigPenomoransTable;
use App\Models\ConfigPenomoran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConfigPenomoranResource extends Resource
{
    protected static ?string $model = ConfigPenomoran::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-hashtag';

    protected static string|\UnitEnum|null $navigationGroup = 'Konfigurasi';

    protected static ?string $navigationLabel = 'Format Penomoran';

    protected static ?string $modelLabel = 'Konfigurasi Penomoran';

    protected static ?string $pluralModelLabel = 'Format Penomoran BAST';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'jenis_dokumen';

    public static function form(Schema $schema): Schema
    {
        return ConfigPenomoranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfigPenomoransTable::configure($table);
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
            'index' => ListConfigPenomorans::route('/'),
            'create' => CreateConfigPenomoran::route('/create'),
            'edit' => EditConfigPenomoran::route('/{record}/edit'),
        ];
    }
}