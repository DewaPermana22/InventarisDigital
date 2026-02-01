<?php

namespace App\Filament\Resources\RiwayatDendas\Pages;

use App\Filament\Resources\RiwayatDendas\RiwayatDendaResource;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatDendas extends ListRecords
{
    protected static string $resource = RiwayatDendaResource::class;
    protected ?string $subheading = "Riwayat denda Anda selama melakukan peminjaman barang";
}
