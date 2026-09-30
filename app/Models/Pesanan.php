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

    /**
     * Relasi ke Permintaan Jasa asal mula pesanan.
     */
    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(PermintaanJasa::class, 'permintaan_id');
    }

    /**
     * Relasi ke Penyedia Jasa yang mengerjakan pesanan.
     */
    public function penyedia(): BelongsTo
    {
        return $this->belongsTo(PenyediaJasa::class, 'penyedia_id');
    }

    /**
     * Relasi ke Pengguna pemesan layanan.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    /**
     * Relasi ke Pembayaran pesanan (1 ke 0..1).
     */
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'pesanan_id');
    }

    /**
     * Relasi ke Ulasan yang diberikan untuk pesanan ini (1 ke 0..N).
     */
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'pesanan_id');
    }
}
