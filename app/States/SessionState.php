<?php

namespace App\States;

use Carbon\Carbon;
use Thunk\Verbs\State;

class SessionState extends State
{
    public int $session_id;
    public int $account_id;
    public int $user_id;
    public int $pnl = 0;
    public string $journal;
    public Carbon $date;
    public bool $is_active = true;
}
