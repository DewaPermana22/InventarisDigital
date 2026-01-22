<?php

namespace App\Filament\Resources\KategoriBarangs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KategoriBarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                ->description('Lengkapi informasi kategori')
                ->components([
            TextInput::make('name')
                ->required()
                ->label('Nama Kategori')
                ->placeholder('contoh. Elektronik')
                ->maxLength(255),
            TextInput::make('prefix')
                ->required()
                ->label('Prefix')
                ->placeholder('masukkan prefix kode barang maksimal 5 Karakter')
                ->maxLength(5),
            ])
        ]);
    }
}
