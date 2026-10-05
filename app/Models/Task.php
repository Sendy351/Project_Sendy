<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'runner_id',
        'category',
        'title',
        'description',
        'pickup_location',
        'dropoff_location',
        'item_price',
        'tip_amount',
        'status',
        'taken_at',
        'delivered_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'item_price' => 'decimal:2',
            'tip_amount' => 'decimal:2',
            'taken_at' => 'datetime',
            'delivered_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Mahasiswa pembuat order tugas (Requester).
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Mahasiswa pelaksana tugas (Runner).
     */
    public function runner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'runner_id');
    }

    /**
     * Bukti serah terima / nota (Order Proof).
     */
    public function proof(): HasOne
    {
        return $this->hasOne(OrderProof::class, 'task_id');
    }

    /**
     * Ulasan / rating untuk tugas ini.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'task_id');
    }

    /**
     * Total biaya = talangan barang + tip runner.
     */
    public function getTotalCostAttribute(): float
    {
        return (float) ($this->item_price + $this->tip_amount);
    }

    /**
     * Format label kategori ramah pengguna.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'print_dokumen' => 'Print Dokumen',
            'titip_makanan' => 'Titip Makanan',
            'ambil_barang' => 'Ambil Barang',
            default => 'Lainnya',
        };
    }
}
