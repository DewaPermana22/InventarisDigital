<?php

namespace App\Filament\Resources\BarangTersedias\Pages;

use App\Filament\Resources\BarangTersedias\BarangTersediaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBarangTersedia extends ViewRecord
{
    protected static string $resource = BarangTersediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
