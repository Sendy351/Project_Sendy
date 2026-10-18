<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'permintaan_id',
        'penyedia_id',
        'pengguna_id',
        'status',
        'diterima_pada',
        'dimulai_pada',
        'selesai_pada',
        'total_harga',
    ];

    protected function casts(): array
    {
        return [
            'diterima_pada' => 'datetime',
            'dimulai_pada' => 'datetime',
            'selesai_pada' => 'datetime',
            'total_harga' => 'decimal:2',
        ];
    }

    public function permintaanJasa(): BelongsTo
    {
        return $this->belongsTo(PermintaanJasa::class, 'permintaan_id');
    }

    public function penyedia(): BelongsTo
    {
        return $this->belongsTo(PenyediaJasa::class, 'penyedia_id');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'pesanan_id');
    }

    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'pesanan_id');
    }
}
