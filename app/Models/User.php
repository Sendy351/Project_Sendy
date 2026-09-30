<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'telepon',
        'alamat',
        'peran',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    /**
     * Get the password for authentication.
     */
    public function getAuthPassword(): string
    {
        return $this->kata_sandi;
    }

    /**
     * Get the name of the password attribute for the user.
     */
    public function getAuthPasswordName(): string
    {
        return 'kata_sandi';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kata_sandi' => 'hashed',
        ];
    }

    /**
     * Relasi ke profil penyedia jasa (1 ke 0..1).
     */
    public function penyediaJasa(): HasOne
    {
        return $this->hasOne(PenyediaJasa::class, 'pengguna_id');
    }

    /**
     * Relasi ke permintaan jasa yang diajukan pengguna (1 ke N).
     */
    public function permintaanJasa(): HasMany
    {
        return $this->hasMany(PermintaanJasa::class, 'pengguna_id');
    }

    /**
     * Relasi ke pesanan pengguna (1 ke N).
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'pengguna_id');
    }

    /**
     * Relasi ke ulasan yang diberikan pengguna (1 ke N).
     */
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'pengguna_id');
    }
}
