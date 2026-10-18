<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenyediaJasa extends Model
{
    use HasFactory;

    protected $table = 'penyedia_jasa';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'pengguna_id',
        'nama',
        'telepon',
        'alamat',
        'deskripsi',
        'status',
        'rating',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:2',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function jasa(): HasMany
    {
        return $this->hasMany(Jasa::class, 'penyedia_id');
    }

    public function permintaanJasa(): HasMany
    {
        return $this->hasMany(PermintaanJasa::class, 'penyedia_id');
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'penyedia_id');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'penyedia_id');
    }
}
