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
    case MENUNGGU_VERIFIKASI = 'proses_verifikasi';
    case MENUNGGU_PERSETUJUAN = 'proses_penyetujuan';
    case VERIFIKASI_DITOLAK = 'verifikasi_ditolak';

    public function label(): string
    {
        return match ($this) {
            self::BELUM_DISETUJUI => 'Menunggu',
            self::DIPINJAM => 'Dipinjam',
            self::DITOLAK => 'Ditolak',
            self::DIBATALKAN => 'Dibatalkan',
            self::DIKEMBALIKAN => 'Dikembalikan',
            self::TERLAMBAT => 'Terlambat',
            self::MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::MENUNGGU_PERSETUJUAN => 'Menunggu (Pengembalian)',
            self::VERIFIKASI_DITOLAK => 'Verifikasi Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BELUM_DISETUJUI => 'warning',
            self::MENUNGGU_PERSETUJUAN => 'warning',
            self::DIPINJAM => 'primary',
            self::DIKEMBALIKAN => 'success',
            self::TERLAMBAT => 'danger',
            self::DIBATALKAN => 'danger',
            self::DITOLAK => 'danger',
            self::VERIFIKASI_DITOLAK => 'danger',
            self::MENUNGGU_VERIFIKASI => 'warning',
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
            self::MENUNGGU_VERIFIKASI,
            self::MENUNGGU_PERSETUJUAN,
            self::VERIFIKASI_DITOLAK,
        ];
    }

    public static function verifikasi(){
        return[
            self::MENUNGGU_PERSETUJUAN,
            self::MENUNGGU_VERIFIKASI
        ];
    }
}
