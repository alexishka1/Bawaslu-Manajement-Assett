<?php

namespace App\Filament\Resources\ConfigTemplates;

use App\Filament\Resources\ConfigTemplates\Pages\CreateConfigTemplate;
use App\Filament\Resources\ConfigTemplates\Pages\EditConfigTemplate;
use App\Filament\Resources\ConfigTemplates\Pages\ListConfigTemplates;
use App\Filament\Resources\ConfigTemplates\Schemas\ConfigTemplateForm;
use App\Filament\Resources\ConfigTemplates\Tables\ConfigTemplatesTable;
use App\Models\ConfigTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConfigTemplateResource extends Resource
{
    protected static ?string $model = ConfigTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static string|\UnitEnum|null $navigationGroup = 'Konfigurasi';

    protected static ?string $navigationLabel = 'Template Dokumen';

    protected static ?string $modelLabel = 'Template Dokumen';

    protected static ?string $pluralModelLabel = 'Daftar Template Dokumen';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nama_template';

    public static function form(Schema $schema): Schema
    {
        return ConfigTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfigTemplatesTable::configure($table);
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
            'index' => ListConfigTemplates::route('/'),
            'create' => CreateConfigTemplate::route('/create'),
            'edit' => EditConfigTemplate::route('/{record}/edit'),
        ];
    }
}