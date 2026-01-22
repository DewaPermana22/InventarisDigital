<?php

namespace App\Models;

use App\Enums\KondisiBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'name',
        'category_id',
        'foto',
        'kondisi',
        'catatan',
        'created_by',
        'updated_by',
        'deleted_by',
        'room_id'
    ];

    protected $casts = [
        'kondisi' => KondisiBarang::class,
        'room_id' => 'integer'
    ];

    public function peminjaman(){
        return $this->hasMany(PeminjamanBarang::class, 'barang_id');
    }

    public function category()
    {
        return $this->belongsTo(KategoriBarang::class, 'category_id');
    }

    public function room()
    {
        return $this->belongsTo(Ruangan::class, 'room_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * ======================
     * BOOT
     * ======================
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            if (empty($barang->kode_barang)) {
                $category = $barang->category ?? $barang->masterItem?->category;
                $prefix = $category?->prefix ?? 'BR';

                $lastBarang = static::withTrashed()
                    ->where('kode_barang', 'like', $prefix . '%')
                    ->orderByRaw('CAST(SUBSTRING(kode_barang, ' . (strlen($prefix) + 2) . ') AS UNSIGNED) DESC')
                    ->first();

                $nextNumber = $lastBarang
                    ? intval(substr($lastBarang->kode_barang, strlen($prefix) + 1)) + 1
                    : 1;

                $barang->kode_barang = $prefix . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
