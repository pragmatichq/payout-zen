<?php

namespace App\Models;

use App\Enums\AccountStatusEnum;
use App\Models\Traits\AccountAttributes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use AccountAttributes;

    protected $guarded = [];

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

    public function sessions(): HasMany
    {
        return $this->hasMany(TradingSession::class);
    }

    // Business Logic
    public function updateAccountStatus(): void
    {
        if ($this->status != AccountStatusEnum::Reset) {
            if ($this->drawdown_remaining <= 0) {
                $this->status = AccountStatusEnum::Failed;
            } elseif ($this->status == AccountStatusEnum::Active && $this->pnl >= $this->profit_goal) {
                $this->status = AccountStatusEnum::Passed;
            } elseif ($this->status == AccountStatusEnum::Passed && $this->pnl < $this->profit_goal) {
                $this->status = AccountStatusEnum::Active;
            } else {
                $this->status = AccountStatusEnum::Active;
            }
        }

        $this->save();
    }

    public function recalculateHighwaterAmount(): void
    {
        $cumulativePnl = 0;
        $highwater = 0;

        $sessions = $this->sessions()->orderBy('date', 'asc')->get();

        foreach ($sessions as $session) {
            $cumulativePnl += $session->pnl;

            if ($cumulativePnl > $highwater) {
                $highwater = $cumulativePnl;
            }
        }

        $this->highwater_amount = $highwater;
        $this->save();
    }

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('status', AccountStatusEnum::Active);
    }

    public function scopeOfAccountFormatType(Builder $query, $type): Builder
    {
        return $query->whereHas('account_format', function (Builder $query) use ($type) {
            $query->where('type', $type);
        });
    }

    // Casting
    protected $casts = [
        'status' => AccountStatusEnum::class,
    ];
}
