<?php

namespace App\States;

use Illuminate\Support\Collection;
use Thunk\Verbs\State;

class AccountState extends State
{
    public int $account_id;
    public int $user_id;
    public array $session_ids = [];
    public bool $is_active = true;

    public int $winning_day_threshold = 100;
    

    public int $pnl = 0;
    public int $winning_days = 0;
    public int $days_traded = 0;

    public function sessions(): Collection
    {
        $sessions = collect($this->session_ids)->map(fn(int $id) => SessionState::load($id));
        return $sessions->filter(function ($state) {
            return $state->is_active;
        });
    }
}
