<?php

namespace App\Filament\Resources\PeminjamanBarangSuperAdmins\Pages;

use App\Filament\Resources\PeminjamanBarangSuperAdmins\PeminjamanBarangSuperAdminResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListPeminjamanBarangSuperAdmins extends ListRecords
{
    protected static string $resource = PeminjamanBarangSuperAdminResource::class;

    public function getSubheading(): string|Htmlable|null
    {
        return "Input peminjaman barang pengguna secara instan tanpa pengajuan";
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make('tambah-peminjaman')
            ->label('Buat Peminjaman')->icon(Heroicon::Plus)
            ->color(Color::Indigo),
        ];
    }
}
