<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradingSession extends Model
{
    protected $guarded = [];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (TradingSession $session) {
            $account = $session->account;
            $user = $account->user;
            $account->updateStatistics();
            $user->updateActivePnl();
        });

        static::deleted(function (TradingSession $session) {
            $account = $session->account;
            $user = $account->user;
            $account->updateStatistics();
            $user->updateActivePnl();
        });
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    protected $casts = [
        'date' => 'date',
    ];
}
