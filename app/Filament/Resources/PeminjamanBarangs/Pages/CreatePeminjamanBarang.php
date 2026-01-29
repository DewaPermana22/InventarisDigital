<?php

namespace App\Filament\Resources\PeminjamanBarangs\Pages;

use App\Enums\HakAkses;
use App\Filament\Resources\PeminjamanBarangs\PeminjamanBarangResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class CreatePeminjamanBarang extends CreateRecord
{
    public function getHeading(): string|Htmlable
    {
        return "Ajukan Peminjaman Barang";
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Pengajuan Berhasil')
            ->body('Silakan menunggu persetujuan dari petugas.')
            ->success();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['peminjam_id'] = Auth::user()->id;
        $data['created_by'] = Auth::user()->id;
        return $data;
    }

    protected static string $resource = PeminjamanBarangResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $barang = $this->record->barang;

        $petugas = User::where('role', HakAkses::ADMIN)
            ->where('is_active', true)
            ->get();

        if ($petugas->isNotEmpty() && $barang) {
            Notification::make()
                ->title('Pengajuan Peminjaman Baru')
                ->body('Ada pengajuan peminjaman barang dari '. $this->record->peminjam->name . ' yang perlu disetujui.')
                ->success()
                ->sendToDatabase($petugas);
        }
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Simpan')
                ->color(Color::Indigo),
            $this->getCancelFormAction()
                ->label('Batal')->color('danger')
        ];
    }
}
