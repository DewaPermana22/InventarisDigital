<?php

namespace App\Filament\Resources\PengajuanPeminjamen\Pages;

use App\Filament\Resources\PengajuanPeminjamen\PengajuanPeminjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanPeminjamen extends ListRecords
{
    protected static string $resource = PengajuanPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
