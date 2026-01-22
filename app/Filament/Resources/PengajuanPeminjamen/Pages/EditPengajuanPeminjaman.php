<?php

namespace App\Filament\Resources\PengajuanPeminjamen\Pages;

use App\Filament\Resources\PengajuanPeminjamen\PengajuanPeminjamanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanPeminjaman extends EditRecord
{
    protected static string $resource = PengajuanPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
