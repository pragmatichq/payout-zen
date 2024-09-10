<?php

namespace App\Events;

use App\States\AccountState;
use App\States\SessionState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class AccountRemoved extends Event
{
    #[StateId(AccountState::class)]
    public int $account_id;

    public function applyToAccount(AccountState $account)
    {
        $account->is_active = false;
    }

    public function fired(): void
    {
        $account = AccountState::load($this->account_id);

        collect($account->session_ids)
            ->map(fn(int $id) => SessionState::load($id))
            ->filter(fn($state) => $state->is_active)
            ->each(function ($session) {
                SessionRemoved::fire(['session_id' => $session->id]);
            });
    }
}
