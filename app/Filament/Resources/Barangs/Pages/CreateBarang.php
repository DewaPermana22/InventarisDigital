<?php

namespace App\Filament\Resources\Barangs\Pages;

use App\Filament\Resources\Barangs\BarangResource;
use App\Models\Barang;
use App\Models\KategoriBarang;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateBarang extends CreateRecord
{
    public function getHeading(): string
    {
        return 'Tambah Barang';
    }

    public function getSubheading(): ?string
    {
        return 'Tambahkan barang di Inventaris anda.';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Simpan')->color(Color::Indigo),
            $this->getCancelFormAction()
                ->label('Batal')->color('danger'),
        ];
    }
    protected static string $resource = BarangResource::class;

    protected function handleRecordCreation(array $data): Barang
    {
        return DB::transaction(function () use ($data) {

            $kategori = KategoriBarang::findOrFail($data['category_id']);
            $qty = (int) $data['qty'];

            $last = Barang::withTrashed()
                ->where('kode_barang', 'like', $kategori->prefix . '-%')
                ->orderByRaw('CAST(SUBSTRING(kode_barang, ' . (strlen($kategori->prefix) + 2) . ') AS UNSIGNED) DESC')
                ->lockForUpdate()
                ->first();

            $lastNumber = $last
                ? (int) preg_replace('/\D/', '', substr($last->kode_barang, strlen($kategori->prefix) + 1))
                : 0;

            $barangTerakhir = null;

            for ($i = 1; $i <= $qty; $i++) {
                $kode = $kategori->prefix . '-' . str_pad($lastNumber + $i, 3, '0', STR_PAD_LEFT);

                $barangTerakhir = Barang::create([
                    'kode_barang' => $kode,
                    'name'        => $data['name'],
                    'category_id' => $kategori->id,
                    'room_id'     => $data['room_id'],
                    'kondisi'     => $data['kondisi'],
                    'catatan'     => $data['catatan'] ?? null,
                    'foto'        => $data['foto'] ?? null,
                    'created_by'  => Auth::id(),
                ]);
            }

            return $barangTerakhir;
        });
    }
}
