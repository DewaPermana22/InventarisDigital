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
        'catatan',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'metode_pembayaran' => MethodePembayaran::class
    ];

        public function peminjaman()
    {
        return $this->belongsTo(PeminjamanBarang::class, 'peminjaman_id');
    }
}
