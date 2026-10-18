<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PermintaanJasa extends Model
{
    use HasFactory;

    protected $table = 'permintaan_jasa';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'pengguna_id',
        'jasa_id',
        'penyedia_id',
        'deskripsi',
        'lokasi',
        'jadwal',
        'status',
        'total_harga',
    ];

    protected function casts(): array
    {
        return [
            'jadwal' => 'datetime',
            'total_harga' => 'decimal:2',
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function jasa(): BelongsTo
    {
        return $this->belongsTo(Jasa::class, 'jasa_id');
    }

    public function penyedia(): BelongsTo
    {
        return $this->belongsTo(PenyediaJasa::class, 'penyedia_id');
    }

    public function pesanan(): HasOne
    {
        return $this->hasOne(Pesanan::class, 'permintaan_id');
    }
}
