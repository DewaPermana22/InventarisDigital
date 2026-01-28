<?php

namespace App\Enums;

enum OpsiBank: string
{
    case BCA = 'bca';
    case BRI = 'bri';
    case MANDIRI = 'mandiri';
    case BNI = 'bni';

    public function label(): string
    {
        return match ($this) {
            self::BCA => 'BCA',
            self::BRI => 'BRI',
            self::MANDIRI => 'Mandiri',
            self::BNI => 'BNI',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
