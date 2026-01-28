<?php

namespace App\Models;

use App\Enums\MethodePembayaran;
use Illuminate\Database\Eloquent\Model;

class VerifikasiPengembalian extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'terverifikasi',
        'metode_pembayaran',
        'path_bukti_pembayaran',
        'nama_bank',
        'nama_ewallet',
        'total_bayar',
        'catatan'
    ];

    protected $casts = [
        'methode_pembayaran' => MethodePembayaran::class
    ];
}
