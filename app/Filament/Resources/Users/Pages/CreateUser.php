<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function getHeading(): string|Htmlable
    {
        return 'Pengguna Baru';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Buat akun pengguna untuk mengakses sistem inventaris';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate password berdasarkan role
        $data['password'] = Hash::make($data['role'] . '-12345');

        return $data;
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Simpan'),
            $this->getCancelFormAction()->label('Batal')->color('danger')
        ];
    }
}
