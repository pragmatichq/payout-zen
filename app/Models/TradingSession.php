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
            $account->updateAccountStatus();
            $account->recalculateHighwaterAmount();
        });

        static::deleted(function (TradingSession $session) {
            $account = $session->account;
            $account->updateAccountStatus();
            $account->recalculateHighwaterAmount();
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
