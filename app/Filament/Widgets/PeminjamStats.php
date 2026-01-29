<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Models\PeminjamanBarang;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PeminjamStats extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return Auth::user()?->role === HakAkses::USER;
    }

    protected function getStats(): array
    {
        $userId = Auth::id();

        $dipinjam = PeminjamanBarang::where('peminjam_id', $userId)
            ->where('status', StatusPeminjaman::DIPINJAM)
            ->count();

        $menunggu = PeminjamanBarang::where('peminjam_id', $userId)
            ->where('status', StatusPeminjaman::BELUM_DISETUJUI)
            ->count();

        $terlambat = PeminjamanBarang::where('peminjam_id', $userId)
            ->where('status', StatusPeminjaman::TERLAMBAT)
            ->count();

        return [
            Stat::make('Sedang Dipinjam', $dipinjam)
                ->description('Barang yang masih Anda pinjam')
                ->descriptionIcon(Heroicon::OutlinedCube)
                ->color('primary'),

            Stat::make('Menunggu Persetujuan', $menunggu)
                ->description('Pengajuan belum disetujui petugas')
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->color('warning'),

            Stat::make('Terlambat', $terlambat)
                ->description('Peminjaman melewati batas waktu')
                ->descriptionIcon(Heroicon::OutlinedExclamationTriangle)
                ->color('danger'),
        ];
    }
}
