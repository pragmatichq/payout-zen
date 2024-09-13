<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradingSession extends Model
{
    protected $guarded = [];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (TradingSession $session) {
            $account = $session->account;
            $account->updateStatistics();
        });

        static::deleted(function (TradingSession $session) {
            $account = $session->account;
            $account->updateStatistics();
        });
    }

    protected $casts = [
        'date' => 'date',
    ];
}
