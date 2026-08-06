<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Components\DateTimePicker;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                \Filament\Schemas\Components\Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'staff' => 'Staff',
                    ])
                    ->required()
                    ->default('staff'),
            ]);
    }
}


