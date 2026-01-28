<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use App\Enums\StatusPeminjaman;
use App\Models\PeminjamanBarang;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PeminjamStats extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return Auth::user()?->role == HakAkses::USER;
    }

    protected function getStats(): array
    {
        $userId = Auth::id();
        return [
            Stat::make(
                'Sedang Dipinjam',
                PeminjamanBarang::where('peminjam_id', $userId)
                    ->where('status', StatusPeminjaman::DIPINJAM)
                    ->count()
            ),

            Stat::make(
                'Menunggu Persetujuan',
                PeminjamanBarang::where('peminjam_id', $userId)
                    ->where('status', StatusPeminjaman::BELUM_DISETUJUI)
                    ->count()
            ),

            Stat::make(
                'Terlambat',
                PeminjamanBarang::where('peminjam_id', $userId)
                    ->where('status', StatusPeminjaman::TERLAMBAT)
                    ->count()
            ),
        ];
    }
}
