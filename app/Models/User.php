<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'pnl',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function updateActivePnl(): void
    {
        $accounts = $this->accounts()->where('status', 'active')->get();
        $active_pnl = $accounts->sum('pnl');
        $this->active_pnl = $active_pnl;

        $this->save();
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
