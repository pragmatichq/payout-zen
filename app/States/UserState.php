<?php

namespace App\States;

use Illuminate\Support\Collection;
use Thunk\Verbs\State;

class UserState extends State
{
    public int $user_id;
    public array $account_ids = [];
    public int $total_pnl = 0;

    public function accounts(): Collection
    {
        $accounts = collect($this->account_ids)->map(fn(int $id) => AccountState::load($id));
        return $accounts->filter(function ($state) {
            return $state->is_active;
        });
    }
}
