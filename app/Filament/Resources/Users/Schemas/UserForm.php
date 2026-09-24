<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),
                TextInput::make('nip')
                    ->label('NIP')
                    ->placeholder('Nomor Induk Pegawai'),
                TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->placeholder('Contoh: Staf IT / BPP'),
                TextInput::make('unit_kerja')
                    ->label('Unit Kerja / Divisi')
                    ->placeholder('Contoh: Subbagian Pengawasan'),
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Select::make('role')
                    ->label('Peran (Role)')
                    ->options([
                        'admin' => 'Admin',
                        'staff' => 'Staff',
                    ])
                    ->required()
                    ->default('staff'),
                Toggle::make('is_verified')
                    ->label('Akun Terverifikasi')
                    ->helperText('Hanya akun terverifikasi yang diizinkan masuk ke sistem.')
                    ->default(true),
            ]);
    }
}
