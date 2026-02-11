<?php

namespace App\Service;

use App\Models\User;
use Milon\Barcode\DNS2D;

class KartuAnggotaService
{
    const ID_BARCODE = 'INV/2026/';

    public function cetakKartu(array $ids): array
    {
        $users = User::select('id', 'name', 'email', 'phone_number')
            ->where('role', 'user')
            ->whereIn('id', $ids)
            ->get();

        $barcode = new DNS2D();
        $barcode->setStorPath(storage_path('app/barcodes'));

        foreach ($users as $user) {
            // Tambahkan kode untuk ditampilkan di kartu
            $user->kode = self::ID_BARCODE . $user->id;

            // Generate barcode
            $user->barcode = $barcode->getBarcodePNG(
                strval($user->id),
                'QRCODE'
            );
        }

        // Load logo
        $logo = base64_encode(
            file_get_contents(public_path('logo/inventarisdg_light.png'))
        );

        return compact('users', 'logo');
    }
}
