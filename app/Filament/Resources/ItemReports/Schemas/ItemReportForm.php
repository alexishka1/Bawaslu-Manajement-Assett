<?php

namespace App\Filament\Resources\ItemReports\Schemas;

use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Schema;

class ItemReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('item_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('kondisi_aktual')
                    ->required(),
                Textarea::make('catatan')
                    ->columnSpanFull(),
                TextInput::make('foto_bukti')
                    ->required(),
            ]);
    }
}


