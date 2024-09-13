<?php

namespace App\Models;

use App\Enums\AccountStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $guarded = [];

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

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
        return $this->hasMany(TradingSession::class);
    }

    public function updateStatistics(): void
    {
        // Get all sessions for the account, ordered by date
        $sessions = $this->trading_sessions()->orderBy('date')->get();

        $pnl = 0;
        $dates = [];
        $values = [];
        $cumulativeBalance = $this->account_format->starting_balance / 100;

        foreach ($sessions as $session) {
            $pnl += $session->pnl;
            $cumulativeBalance += $session->pnl / 100;
            $dates[] = $session->date->toDateString();
            $values[] = $cumulativeBalance;
        }

        $balanceOverTime = [
            'dates' => $dates,
            'values' => $values
        ];

        $this->balance_over_time = $balanceOverTime;
        $this->pnl = $pnl;
        $this->current_balance = $pnl + $this->account_format->starting_balance;

        $this->save();
    }

    protected function casts(): array
    {
        return [
            'status' => AccountStatusEnum::class,
            'balance_over_time' => 'array',
        ];
    }
}
