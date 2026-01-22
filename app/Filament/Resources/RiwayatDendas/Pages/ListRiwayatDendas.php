<?php

namespace App\Filament\Resources\RiwayatDendas\Pages;

use App\Filament\Resources\RiwayatDendas\RiwayatDendaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatDendas extends ListRecords
{
    protected static string $resource = RiwayatDendaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
