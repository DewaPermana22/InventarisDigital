<?php

namespace App\Filament\Resources\RiwayatDendas\Pages;

use App\Filament\Resources\RiwayatDendas\RiwayatDendaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRiwayatDenda extends ViewRecord
{
    protected static string $resource = RiwayatDendaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
