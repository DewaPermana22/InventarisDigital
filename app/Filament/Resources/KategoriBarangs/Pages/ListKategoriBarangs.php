<?php

namespace App\Filament\Resources\KategoriBarangs\Pages;

use App\Filament\Resources\KategoriBarangs\KategoriBarangResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ListKategoriBarangs extends ListRecords
{
    protected static string $resource = KategoriBarangResource::class;

    public function getHeading(): string
    {
        return 'Kategori Barang';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola data kategori barang sistem anda di sini';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Kategori')->icon(Heroicon::Plus)
            ->color(Color::Indigo),
        ];
    }
}
