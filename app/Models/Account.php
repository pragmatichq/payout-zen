<?php

namespace App\Models;

use App\Enums\AccountStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Account $account) {
            $user = $account->user;
            $account->updateStatistics(false);
            $user->updateActivePnl();
        });

        static::deleted(function (Account $account) {
            $user = $account->user;
            $account->updateStatistics(false);
            $user->updateActivePnl();
        });
    }

    public function updateStatistics(bool $save = true): void
    {
        $sessions = $this->trading_sessions()->get();
        $pnl = $sessions->sum('pnl');
        $starting_balance = $this->account_format->starting_balance;
        $starting_balance_in_dollars = ($starting_balance / 100);
        $balance_over_time = $this->calculateBalanceOverTime($sessions, $starting_balance_in_dollars);

        $this->balance_over_time = $balance_over_time;
        $this->pnl = $pnl;
        $this->current_balance = $pnl + $starting_balance;

        if ($save) {
            $this->save();
        }
    }

    private function calculateBalanceOverTime($sessions, $starting_balance_in_dollars): array
    {
        $cumulativeBalance = $starting_balance_in_dollars;
        $dates = [];
        $values = [];

        foreach ($sessions as $session) {
            $cumulativeBalance += ($session->pnl / 100);
            $dates[] = $session->date->toDateString();
            $values[] = $cumulativeBalance;
        }

        return [
            'dates' => $dates,
            'values' => $values,
        ];
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
        return $this->hasMany(TradingSession::class)->orderBy('date');
    }

    protected function casts(): array
    {
        return [
            'status' => AccountStatusEnum::class,
            'balance_over_time' => 'array',
        ];
    }
}
