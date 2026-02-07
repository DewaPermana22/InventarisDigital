<?php

namespace App\Filament\Resources\PeminjamanBarangAdmin\Pages;

use App\Filament\Resources\PeminjamanBarangAdmin\PeminjamanBarangAdminResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListPeminjamanBarangAdmin extends ListRecords
{
    protected static string $resource = PeminjamanBarangAdminResource::class;

    public function getSubheading(): string|Htmlable|null
    {
        return 'Input peminjaman barang pengguna secara instan tanpa pengajuan';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make('tambah_peminjaman')
                ->label('Buat Peminjaman')
                ->icon(Heroicon::Plus)
                ->color(Color::Indigo),
        ];
    }
}
