<?php

namespace App\Filament\Resources\RefPegawais;

use App\Filament\Resources\RefPegawais\Pages\CreateRefPegawai;
use App\Filament\Resources\RefPegawais\Pages\EditRefPegawai;
use App\Filament\Resources\RefPegawais\Pages\ListRefPegawais;
use App\Filament\Resources\RefPegawais\Pages\ViewRefPegawai;
use App\Filament\Resources\RefPegawais\Schemas\RefPegawaiForm;
use App\Filament\Resources\RefPegawais\Schemas\RefPegawaiInfolist;
use App\Filament\Resources\RefPegawais\Tables\RefPegawaisTable;
use App\Models\RefPegawai;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class RefPegawaiResource extends Resource
{
    protected static ?string $model = RefPegawai::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|\UnitEnum|null $navigationGroup = 'Data Referensi';

    protected static ?string $navigationLabel = 'Master Pegawai';

    protected static ?string $modelLabel = 'Pegawai';

    protected static ?string $pluralModelLabel = 'Daftar Pegawai';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return RefPegawaiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RefPegawaiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RefPegawaisTable::configure($table);
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
            'index' => ListRefPegawais::route('/'),
            'create' => CreateRefPegawai::route('/create'),
            'view' => ViewRefPegawai::route('/{record}'),
            'edit' => EditRefPegawai::route('/{record}/edit'),
        ];
    }
}
