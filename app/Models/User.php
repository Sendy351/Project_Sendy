<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nim',
        'phone',
        'avatar',
        'role',
        'wallet_balance',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'wallet_balance' => 'decimal:2',
        ];
    }

    /**
     * Tugas yang dibuat sebagai Requester.
     */
    public function requestedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'requester_id');
    }

    /**
     * Tugas yang diambil sebagai Runner.
     */
    public function runningTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'runner_id');
    }

    /**
     * Mutasi saldo dompet.
     */
    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'user_id');
    }

    /**
     * Ulasan yang diterima pengguna.
     */
    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    /**
     * Rata-rata rating bintang yang diterima.
     */
    public function averageRating(): float
    {
        return (float) ($this->reviewsReceived()->avg('rating') ?? 5.0);
    }
}
