<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jasa extends Model
{
    use HasFactory;

    protected $table = 'jasa';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'kategori_id',
        'penyedia_id',
        'nama',
        'deskripsi',
        'harga',
        'durasi',
        'gambar',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriJasa::class, 'kategori_id');
    }

    public function penyedia(): BelongsTo
    {
        return $this->belongsTo(PenyediaJasa::class, 'penyedia_id');
    }

    public function permintaanJasa(): HasMany
    {
        return $this->hasMany(PermintaanJasa::class, 'jasa_id');
    }
}
