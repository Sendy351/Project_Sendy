<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesanChat extends Model
{
    protected $table = 'pesan_chat';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'pesanan_id',
        'pengirim_id',
        'isi',
        'foto_path',
        'foto_data',
        'dibaca_pada',
    ];

    /**
     * foto_data berisi biner gambar: jangan pernah ikut ke JSON/array.
     */
    protected $hidden = [
        'foto_data',
    ];

    protected function casts(): array
    {
        return [
            'dibaca_pada' => 'datetime',
            'dibuat_pada' => 'datetime',
        ];
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengirim_id');
    }
}
