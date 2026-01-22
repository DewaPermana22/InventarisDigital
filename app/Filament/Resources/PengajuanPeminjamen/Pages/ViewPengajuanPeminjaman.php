<?php

namespace App\Filament\Resources\PengajuanPeminjamen\Pages;

use App\Filament\Resources\PengajuanPeminjamen\PengajuanPeminjamanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPengajuanPeminjaman extends ViewRecord
{
    protected static string $resource = PengajuanPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
