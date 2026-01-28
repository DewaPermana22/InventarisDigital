<?php

namespace App\Filament\Resources\PeminjamanRuanganSuperAdmins\Pages;

use App\Filament\Resources\PeminjamanRuanganSuperAdmins\PeminjamanRuanganSuperAdminResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPeminjamanRuanganSuperAdmin extends EditRecord
{
    protected static string $resource = PeminjamanRuanganSuperAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
