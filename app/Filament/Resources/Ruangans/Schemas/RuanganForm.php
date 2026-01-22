<?php

namespace App\Filament\Resources\Ruangans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RuanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Ruangan')
                    ->description(fn(string $operation): string =>
                    $operation === 'create'
                        ? 'Lengkapi semua data'
                        : 'Pastikan data valid sebelum menyimpan')
                    ->components([
                        TextInput::make('name')
                        ->label('Nama Ruangan')
                        ->placeholder('Contoh. Ruangan 1')
                        ->required()
                    ])
            ]);
    }
}
