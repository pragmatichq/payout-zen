<?php

namespace App\Events;

use App\States\AccountState;
use App\States\UserState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class AccountCreated extends Event
{
    #[StateId(AccountState::class)]
    public ?int $account_id = null;

    #[StateId(UserState::class)]
    public int $user_id;

    public function applyToAccount(AccountState $account): void
    {
        $account->user_id = $this->user_id;
    }

    public function applyToUser(UserState $user): void
    {
        $user->account_ids[] = $this->account_id;
    }
}
