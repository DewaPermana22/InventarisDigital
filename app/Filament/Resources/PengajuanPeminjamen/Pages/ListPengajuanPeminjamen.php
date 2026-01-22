<?php

namespace App\Filament\Resources\PengajuanPeminjamen\Pages;

use App\Filament\Resources\PengajuanPeminjamen\PengajuanPeminjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListPengajuanPeminjamen extends ListRecords
{
    protected static string $resource = PengajuanPeminjamanResource::class;
    protected static ?string $title = "Pengajuan Peminjaman";

    public function getHeading(): string|Htmlable
    {
        return "Pengajuan Peminjaman";
    }
    public function getSubheading(): string|Htmlable|null
    {
        return "Daftar pengajuan peminjaman barang yang telah diajukan";
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon(Heroicon::Plus)
                ->color(Color::Indigo)
                ->label('Tambah Peminjaman'),
        ];
    }
}
