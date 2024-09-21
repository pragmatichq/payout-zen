<?php

namespace App\Models;

use App\Enums\AccountStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $guarded = [];

    // Relationship Definitions
    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    public function account_format(): BelongsTo
    {
        return $this->belongsTo(AccountFormat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trading_sessions(): HasMany
    {
        return $this->hasMany(TradingSession::class)->orderBy('date', 'desc');
    }

    // Attribute Accessors
    public function getStartingBalanceAttribute()
    {
        return $this->account_format->starting_balance ?? 0;
    }

    public function getPnlAttribute()
    {
        return $this->tradingSessions()->sum('pnl');
    }

    public function getCurrentBalanceAttribute()
    {
        return $this->starting_balance + $this->pnl;
    }

    public function getProfitGoalAttribute()
    {
        return $this->account_format->profit_goal ?? 0;
    }

    public function getProfitGoalProgressAttribute(): float|int
    {
        return $this->profit_goal > 0 ? ($this->pnl / $this->profit_goal * 100) : 0;
    }

    // Business Logic
    public function updateAccountStatus(): void
    {
        if ($this->status == AccountStatusEnum::Active && $this->pnl >= $this->profit_goal) {
            $this->status = AccountStatusEnum::Passed;
        } elseif ($this->status == AccountStatusEnum::Passed && $this->pnl < $this->profit_goal) {
            $this->status = AccountStatusEnum::Active;
        }

        $this->save();
    }

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('status', AccountStatusEnum::Active);
    }

    public function scopeOfAccountFormatType(Builder $query, $type): Builder
    {
        return $query->whereHas('account_ormat', function (Builder $query) use ($type) {
            $query->where('type', $type);
        });
    }

    // Casting
    protected $casts = [
        'status' => AccountStatusEnum::class,
    ];
}
