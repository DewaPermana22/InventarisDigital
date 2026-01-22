<?php

namespace App\Models;

use App\Enums\StatusPeminjaman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeminjamanBarang extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'peminjam_id',
        'barang_id',
        'tanggal_disetujui',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jumlah',
        'status',
    ];

    // Untuk memastikan data yang kita input dari aplikasi sesuai dengan tipe data di database
    protected $casts = [
        'tanggal_disetujui' => 'date',
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'status' => StatusPeminjaman::class,
    ];

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
