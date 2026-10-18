<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriJasa extends Model
{
    use HasFactory;

    protected $table = 'kategori_jasa';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'nama',
        'deskripsi',
        'ikon',
    ];

    public function jasa(): HasMany
    {
        return $this->hasMany(Jasa::class, 'kategori_id');
    }
}
