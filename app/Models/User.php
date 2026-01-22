<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\HakAkses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'profile_pict'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'role' => HakAkses::class
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin()
    {
        return $this->role === HakAkses::SUPERADMIN;
    }
    public function isAdmin()
    {
        return $this->role === HakAkses::ADMIN;
    }
    public function isUser()
    {
        return $this->role === HakAkses::USER;
    }
    public function createdBarangs()
    {
        return $this->hasMany(Barang::class, 'created_by');
    }

    public function updatedBarangs()
    {
        return $this->hasMany(Barang::class, 'updated_by');
    }

    public function deletedBarangs()
    {
        return $this->hasMany(Barang::class, 'deleted_by');
    }
}
