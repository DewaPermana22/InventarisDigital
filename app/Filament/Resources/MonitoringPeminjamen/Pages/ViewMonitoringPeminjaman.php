<?php

namespace App\Filament\Resources\MonitoringPeminjamen\Pages;

use App\Filament\Resources\MonitoringPeminjamen\MonitoringPeminjamanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMonitoringPeminjaman extends ViewRecord
{
    protected static string $resource = MonitoringPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
