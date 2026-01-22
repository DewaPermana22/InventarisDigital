<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriBarang extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'prefix',
        'created_by',
        'deleted_by',
        'updated_by',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'category_id');
    }
}
