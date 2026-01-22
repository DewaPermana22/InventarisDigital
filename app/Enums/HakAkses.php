<?php

namespace App\Enums;

enum HakAkses: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case USER = 'user';


    //Untuk Formating tampilan di Tabel
    public function label()
    {
        return match ($this) {
            self::SUPERADMIN => 'Superadmin',
            self::ADMIN => 'Petugas',
            self::USER => 'User'
        };
    }
}
