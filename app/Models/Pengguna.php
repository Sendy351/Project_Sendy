<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'telepon',
        'alamat',
        'peran',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    public function getAuthPasswordName(): string
    {
        return 'kata_sandi';
    }

    public function getAuthPassword(): string
    {
        return $this->kata_sandi;
    }

    /**
     * Getter nama untuk kompatibilitas tampilan
     */
    public function getNameAttribute(): string
    {
        return $this->nama;
    }

    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function isPenyedia(): bool
    {
        return $this->peran === 'penyedia';
    }

    public function isPelanggan(): bool
    {
        return $this->peran === 'pelanggan' || $this->peran === 'pengguna';
    }

    /**
     * Relasi ke profil Penyedia Jasa (0..1)
     */
    public function penyediaJasa(): HasOne
    {
        return $this->hasOne(PenyediaJasa::class, 'pengguna_id');
    }

    /**
     * Permintaan jasa yang diajukan pengguna (1..N)
     */
    public function permintaanJasa(): HasMany
    {
        return $this->hasMany(PermintaanJasa::class, 'pengguna_id');
    }

    /**
     * Pesanan jasa yang dimiliki pengguna (1..N)
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'pengguna_id');
    }

    /**
     * Ulasan yang diberikan pengguna (1..N)
     */
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'pengguna_id');
    }
}
