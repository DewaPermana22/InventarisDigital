<?php

namespace App\Enums;

enum StatusPeminjaman: string
{
    case BELUM_DISETUJUI = 'menunggu_persetujuan';
    case DIBATALKAN = 'dibatalkan';
    case DITOLAK = 'ditolak';
    case DIPINJAM = 'dipinjam';
    case DIKEMBALIKAN = 'dikembalikan';
    case TERLAMBAT = 'terlambat';

    public function label(): string
    {
        return match ($this) {
            self::BELUM_DISETUJUI => 'Menunggu',
            self::DIPINJAM => 'Dipinjam',
            self::DITOLAK => 'Ditolak',
            self::DIBATALKAN => 'Dibatalkan',
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
            self::DIBATALKAN => 'danger',
            self::DITOLAK => 'danger',
        };
    }

    // Untuk filtering barang tersedia
    public static function inactive(): array
    {
        return [
            self::DIKEMBALIKAN,
            self::DIBATALKAN,
            self::DITOLAK,
        ];
    }

    // Untuk Filtering peminjaman yang aktif
    public static function active(){
        return [
            self::BELUM_DISETUJUI,
            self::DIPINJAM,
            self::TERLAMBAT,
        ];
    }
}
