<?php

namespace App\Filament\Resources\BarangTersedias\Pages;

use App\Filament\Resources\BarangTersedias\BarangTersediaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBarangTersedia extends EditRecord
{
    protected static string $resource = BarangTersediaResource::class;

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
