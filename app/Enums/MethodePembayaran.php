<?php

namespace App\Enums;

enum MethodePembayaran: string
{
    case QRIS = 'qris';
    case CASH = 'cash';
    case TRANSFER = 'transfer';
    case EWALLET = 'ewallet';

    public function label(): string
    {
        return match ($this) {
            self::QRIS => 'QRIS',
            self::CASH => 'Cash',
            self::TRANSFER => 'Transfer Bank',
            self::EWALLET => 'E-Wallet',
        };
    }
}
