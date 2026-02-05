<?php

namespace App\Filament\Resources\MonitoringPeminjamen\Pages;

use App\Filament\Resources\MonitoringPeminjamen\MonitoringPeminjamanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListMonitoringPeminjamen extends ListRecords
{
    protected static string $resource = MonitoringPeminjamanResource::class;

    public function getSubheading(): string|Htmlable|null
    {
        return "Kelola dan awasi peminjaman barang agar proses inventaris tetap terkontrol";
    }
}
