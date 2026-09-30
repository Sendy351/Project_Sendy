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

    /**
     * Relasi ke Pengguna yang mengajukan permintaan.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    /**
     * Relasi ke layanan Jasa yang dipilih (opsional).
     */
    public function jasa(): BelongsTo
    {
        return $this->belongsTo(Jasa::class, 'jasa_id');
    }

    /**
     * Relasi ke Penyedia Jasa yang dituju (opsional).
     */
    public function penyedia(): BelongsTo
    {
        return $this->belongsTo(PenyediaJasa::class, 'penyedia_id');
    }

    /**
     * Relasi ke Pesanan yang memproses permintaan ini (1 ke 1).
     */
    public function pesanan(): HasOne
    {
        return $this->hasOne(Pesanan::class, 'permintaan_id');
    }
}
