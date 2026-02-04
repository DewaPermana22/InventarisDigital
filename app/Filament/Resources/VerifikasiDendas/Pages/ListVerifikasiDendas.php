<?php

namespace App\Filament\Resources\VerifikasiDendas\Pages;

use App\Filament\Resources\VerifikasiDendas\VerifikasiDendaResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListVerifikasiDendas extends ListRecords
{
    protected static string $resource = VerifikasiDendaResource::class;

    public function getSubheading(): string|Htmlable|null
    {
        return "Daftar pengajuan pengembalian barang yang dikenai denda";

    }
}
