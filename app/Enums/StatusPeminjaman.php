<?php

namespace App\Enums;

enum StatusPeminjaman: string
{
    case BELUM_DISETUJUI = 'menunggu_persetujuan';
    case DIPINJAM = 'dipinjam';
    case DIKEMBALIKAN = 'dikembalikan';
    case TERLAMBAT = 'terlambat';

    public function label(): string
    {
        return match ($this) {
            self::BELUM_DISETUJUI => 'Menunggu',
            self::DIPINJAM => 'Dipinjam',
            self::DIKEMBALIKAN => 'Dikembalikan',
            self::TERLAMBAT => 'Terlambat',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BELUM_DISETUJUI => 'warning',
            self::DIPINJAM => 'primary',
            self::DIKEMBALIKAN => 'success',
            self::TERLAMBAT => 'danger',
        };
    }
}
