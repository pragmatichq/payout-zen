<?php

namespace App\Events;

use App\Models\Account;
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

    public function applyToAccount(AccountState $account)
    {
        $account->user_id = $this->user_id;
    }

    public function handle(): Account
    {
        return Account::create([
            'id' => $this->account_id,
            'user_id' => $this->user_id,
        ]);
    }
}
