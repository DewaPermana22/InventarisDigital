<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruangan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'created_by',
        'deleted_by',
        'updated_by',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'room_id');
    }
}
