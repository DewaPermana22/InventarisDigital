<?php

namespace App\Filament\Resources\BarangTersedias\Pages;

use App\Filament\Resources\BarangTersedias\BarangTersediaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListBarangTersedias extends ListRecords
{
    protected static string $resource = BarangTersediaResource::class;
    public function getHeading(): string|Htmlable
    {
        return "Barang Tersedia";
    }

    public function getSubheading(): string|Htmlable|null
    {
        return "Daftar barang yang saat ini tersedia untuk dipinjam";
    }
}
