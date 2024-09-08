<?php

namespace App\Events\Auth;

use App\States\UserState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class UserLoggedIn extends Event
{
    #[StateId(UserState::class)]
    public int $user_id;

    public function handle()
    {

    }
}
