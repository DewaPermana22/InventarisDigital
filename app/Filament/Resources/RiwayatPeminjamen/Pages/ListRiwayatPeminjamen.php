<?php

namespace App\Filament\Resources\RiwayatPeminjamen\Pages;

use App\Filament\Resources\RiwayatPeminjamen\RiwayatPeminjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatPeminjamen extends ListRecords
{
    protected static string $resource = RiwayatPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
