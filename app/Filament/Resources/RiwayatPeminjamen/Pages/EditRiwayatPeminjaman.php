<?php

namespace App\Filament\Resources\RiwayatPeminjamen\Pages;

use App\Filament\Resources\RiwayatPeminjamen\RiwayatPeminjamanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatPeminjaman extends EditRecord
{
    protected static string $resource = RiwayatPeminjamanResource::class;

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
