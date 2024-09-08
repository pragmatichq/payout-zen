<?php

namespace App\States;

use Thunk\Verbs\State;

class UserState extends State
{
    public int $user_id;
    public string $email;
    public string $name;
}
