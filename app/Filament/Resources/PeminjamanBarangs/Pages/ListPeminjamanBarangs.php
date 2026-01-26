<?php

namespace App\Filament\Resources\PeminjamanBarangs\Pages;

use App\Filament\Resources\PeminjamanBarangs\PeminjamanBarangResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListPeminjamanBarangs extends ListRecords
{
    public ?string $barcode = null;
    protected static string $resource = PeminjamanBarangResource::class;

    public function getSubheading(): string|Htmlable|null
    {
        return "Ajukan peminjaman barang yang tersedia";
    }
    
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon(Heroicon::Plus)
                ->label('Pinjam Barang')
                ->color(Color::Indigo),
        ];
    }
}
