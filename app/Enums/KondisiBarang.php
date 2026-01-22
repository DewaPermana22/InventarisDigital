<?php

namespace App\Enums;

enum KondisiBarang: string
{
    case BAIK = 'baik';
    case RUSAK = 'rusak';
    case PERBAIKAN = 'perbaikan';

    public function label(): string
    {
        return match ($this) {
            self::BAIK => 'Baik',
            self::RUSAK => 'Rusak',
            self::PERBAIKAN => 'Perbaikan',
        };
    }
}
