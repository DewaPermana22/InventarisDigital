<?php

namespace App\Filament\Resources\DataPengembalians\Pages;

use App\Filament\Resources\DataPengembalians\DataPengembalianResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDataPengembalian extends ViewRecord
{
    protected static string $resource = DataPengembalianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
