<?php

namespace App\Events;

use App\States\AccountState;
use App\States\SessionState;
use App\States\UserState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class SessionRemoved extends Event
{

    #[StateId(SessionState::class)]
    public int $session_id;

    #[StateId(AccountState::class)]
    public int $account_id;

    #[StateId(UserState::class)]
    public int $user_id;

    public int $pnl;

    public function __construct(int $session_id)
    {
        $this->session_id = $session_id;
        $session = SessionState::load($this->session_id);
        $this->account_id = $session->account_id;
        $this->user_id = $session->user_id;
        $this->pnl = $session->pnl;
    }

    public function applyToSession(SessionState $session)
    {
        $session->is_active = false;
    }

    public function applyToAccount(AccountState $account)
    {
        $account->pnl -= $this->pnl;
        $account->days_traded--;
        if ($this->pnl > $account->winning_day_threshold) {
            $account->winning_days--;
        }
    }

    public function applyToUser(UserState $user)
    {
        $user->total_pnl -= $this->pnl;
    }

}
