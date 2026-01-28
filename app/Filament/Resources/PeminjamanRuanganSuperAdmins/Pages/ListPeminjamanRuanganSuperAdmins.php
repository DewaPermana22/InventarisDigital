<?php

namespace App\Filament\Resources\PeminjamanRuanganSuperAdmins\Pages;

use App\Filament\Resources\PeminjamanRuanganSuperAdmins\PeminjamanRuanganSuperAdminResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamanRuanganSuperAdmins extends ListRecords
{
    protected static string $resource = PeminjamanRuanganSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
