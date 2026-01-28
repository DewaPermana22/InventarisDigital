<?php

namespace App\Filament\Resources\DataPengembalians\Pages;

use App\Filament\Resources\DataPengembalians\DataPengembalianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListDataPengembalians extends ListRecords
{
    protected static string $resource = DataPengembalianResource::class;

    public function getTitle(): string|Htmlable
    {
        return "Data Pengembalian";
    }

    public function getSubheading(): string|Htmlable|null
    {
        return "Daftar pengajuan pengembalian barang yang telah dikirimkan";
    }
}

//Menampilkan daftar pengembalian barang yang dikenakan denda. (subheading)
//Riwayat Pengembalian Berdenda (heading)
//Pengembalian Berdenda (navigation label)
//Belum ada pengembalian berdenda (empty state heading)
//Tidak ada data pengembalian barang yang terkena denda saat ini. (deskripsi empty state)
