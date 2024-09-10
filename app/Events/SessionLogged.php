<?php

namespace App\Events;

use App\States\AccountState;
use App\States\SessionState;
use App\States\UserState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class SessionLogged extends Event
{
    #[StateId(SessionState::class)]
    public ?int $session_id = null;

    #[StateId(AccountState::class)]
    public int $account_id;

    #[StateId(UserState::class)]
    public int $user_id;

    public int $pnl;

    public function applyToSession(SessionState $session): void
    {
        $session->pnl = $this->pnl;
        $session->account_id = $this->account_id;
        $session->user_id = $this->user_id;
    }

    public function applyToAccount(AccountState $account): void
    {
        $account->pnl += $this->pnl;
        $account->session_ids[] = $this->session_id;
        $account->days_traded++;
        if ($this->pnl > $account->winning_day_threshold) {
            $account->winning_days++;
        }
    }


    public function applyToUser(UserState $user): void
    {
        $user->total_pnl += $this->pnl;
    }


}
