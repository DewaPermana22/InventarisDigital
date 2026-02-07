<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\HakAkses;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ViewRecord;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengguna')
                    ->description(function ($livewire) {
                        if ($livewire instanceof CreateRecord) {
                            return 'Lengkapi data di bawah ini untuk menambahkan akun pengguna baru.';
                        }

                        if ($livewire instanceof EditRecord) {
                            return 'Perbarui data akun pengguna yang sudah terdaftar.';
                        }

                        if ($livewire instanceof ViewRecord) {
                            return 'Berikut adalah detail informasi akun pengguna.';
                        }

                        return null;
                    })

                    ->components([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('phone_number')
                            ->label('Nomor Telepon')
                            ->rule('regex:/^\+?[0-9]{10,15}$/')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(15),

                        Select::make('role')
                            ->label('Role')
                            ->options(
                                collect(HakAkses::cases())
                                    ->mapWithKeys(fn($case) => [
                                        $case->value => $case->label(),
                                    ])
                                    ->toArray()
                            )
                            ->default(HakAkses::USER->value)
                            ->required()
                            ->native(false)
                            ->live(),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),

                        Placeholder::make('password_info')
                            ->label('Password Default')
                            ->content(function ($get) {
                                $role = $get('role') ?? HakAkses::USER->value;
                                return '🔑 Password otomatis: ' . $role . '-12345';
                            })
                            ->visibleOn('create'),
                    ])
            ]);
    }
}
