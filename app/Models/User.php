<?php

namespace App\Models;

use App\Enums\AccountFormatTypeEnum;
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

    // Relationship Definitions
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    // Attribute Accessors
    public function getFundedPnlAttribute()
    {
        $accounts = $this->accounts()->active()->ofAccountFormatType(AccountFormatTypeEnum::Funded)->get();

        return $accounts->sum(function ($account) {
            return $account->pnl;
        });
    }

    public function getEvaluationPnlAttribute()
    {
        $accounts = $this->accounts()->active()->ofAccountFormatType(AccountFormatTypeEnum::Evaluation)->get();

        return $accounts->sum(function ($account) {
            return $account->pnl;
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
