<?php

namespace App\Enums;

enum OpsiEwallet: string
{
    case GOPAY = 'gopay';
    case DANA = 'dana';
    case OVO = 'ovo';
    case SHOPEEPAY = 'shopeepay';

    public function label(): string
    {
        return match ($this) {
            self::GOPAY => 'GoPay',
            self::DANA => 'Dana',
            self::OVO => 'OVO',
            self::SHOPEEPAY => 'ShopeePay',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
