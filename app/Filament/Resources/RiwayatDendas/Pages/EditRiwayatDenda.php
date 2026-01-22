<?php

namespace App\Filament\Resources\RiwayatDendas\Pages;

use App\Filament\Resources\RiwayatDendas\RiwayatDendaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatDenda extends EditRecord
{
    protected static string $resource = RiwayatDendaResource::class;

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
