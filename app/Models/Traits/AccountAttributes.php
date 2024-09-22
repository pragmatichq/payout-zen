<?php

namespace App\Models\Traits;

trait AccountAttributes
{
    public function getStartingBalanceAttribute()
    {
        return $this->account_format->starting_balance ?? 0;
    }

    public function getPnlAttribute()
    {
        return $this->sessions->sum('pnl');
    }

    public function getCurrentBalanceAttribute()
    {
        return $this->starting_balance + $this->pnl;
    }

    public function getProfitGoalAttribute()
    {
        return $this->account_format->profit_goal ?? 0;
    }

    public function getProfitGoalProgressAttribute(): float
    {
        return $this->pnl > 0 ? ($this->pnl / $this->profit_goal * 100) : 0;
    }

    public function getDistanceFromProfitGoalAttribute()
    {
        return max($this->profit_goal - $this->pnl, 0);
    }

    public function getDrawdownThresholdAttribute()
    {
        return $this->account_format->drawdown_threshold ?? 0;
    }

    public function getMaximumLossLimitAttribute()
    {
        return min($this->starting_balance + ($this->highwater_amount - $this->drawdown_threshold), $this->starting_balance);
    }

    public function getDrawdownRemainingAttribute()
    {
        return $this->current_balance - $this->maximum_loss_limit;
    }
}
