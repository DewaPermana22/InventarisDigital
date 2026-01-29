<?php

namespace App\Filament\Resources\PeminjamanBarangSuperAdmins\Pages;

use App\Enums\StatusPeminjaman;
use App\Filament\Resources\PeminjamanBarangSuperAdmins\PeminjamanBarangSuperAdminResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;

class CreatePeminjamanBarangSuperAdmin extends CreateRecord
{
    protected static string $resource = PeminjamanBarangSuperAdminResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['petugas_id'] = Auth::id();
        $data['status'] = StatusPeminjaman::DIPINJAM;
        $data['tanggal_pinjam'] = now();
        $data['tanggal_disetujui'] = now();
        $data['tanggal_kembali'] = now()->copy()->addDays(7);
        $data['created_by'] = Auth::id();
        $data['updated_at'] = now();
        $data['updated_by'] = Auth::id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $peminjam = User::find($this->record->peminjam_id);
        $barang = $this->record->barang;

        if ($peminjam && $barang) {
            Notification::make()
                ->title('Peminjaman Barang Baru')
                ->body('Anda memiliki peminjaman barang baru. Silakan cek detail peminjaman Anda.')
                ->success()
                ->sendToDatabase($peminjam);
        }
        Notification::make()
            ->title('Data peminjaman berhasil ditambahkan')
            ->body(
                'Anda baru saja menambahkan peminjaman barang untuk '
                    . $peminjam->name
                    . ' dengan barang: '
                    . $barang->name
                    . ' (' . $barang->kode_barang . ')'
            )
            ->success()
            ->sendToDatabase(Auth::user());
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
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
