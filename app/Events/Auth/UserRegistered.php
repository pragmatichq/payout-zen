<?php

namespace App\Events\Auth;

use App\Models\User;
use App\States\UserState;
use Illuminate\Auth\Events\Registered;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class UserRegistered extends Event
{
    #[StateId(UserState::class)]
    public ?int $user_id = null;

    public array $validated;

    public function apply(UserState $state): void
    {
        $state->user_id = $this->user_id;
        $state->email = $this->validated['email'];
        $state->name = $this->validated['name'];
    }

    public function handle(): User
    {
        $this->validated['id'] = $this->user_id;
        event(new Registered($user = User::create($this->validated)));
        return $user;
    }
}
