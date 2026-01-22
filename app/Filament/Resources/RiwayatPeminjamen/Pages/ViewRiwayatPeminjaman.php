<?php

namespace App\Filament\Resources\RiwayatPeminjamen\Pages;

use App\Filament\Resources\RiwayatPeminjamen\RiwayatPeminjamanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRiwayatPeminjaman extends ViewRecord
{
    protected static string $resource = RiwayatPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
