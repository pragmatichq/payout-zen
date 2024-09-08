<?php

namespace App\States;

use Thunk\Verbs\State;

class SessionState extends State
{
    public int $pnl = 0;
    public string $journal;
}
