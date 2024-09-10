<?php

use App\Events\AccountCreated;
use App\Events\AccountRemoved;
use App\Events\SessionLogged;
use App\Events\SessionRemoved;
use App\States\UserState;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component {
    #[Layout('layouts.test')]
    public function with(): array
    {
        $user = UserState::load(1);

        return [
            'user' => $user,
            'accounts' => $user->accounts(),
        ];
    }

    public function addAccount(): void
    {
        AccountCreated::fire([
            'user_id' => 1,
        ]);
    }

    public function logSession(string $account_id): void
    {
        SessionLogged::fire([
            'account_id' => (int)$account_id,
            'user_id' => 1,
            'pnl' => rand(-500, 500)
        ]);
    }

    public function removeSession(string $session_id, string $account_id): void
    {
        SessionRemoved::fire([
            'session_id' => (int)$session_id
        ]);
    }

    public function removeAccount(string $account_id): void
    {
        AccountRemoved::fire([
            'account_id' => (int)$account_id
        ]);
    }
}; ?>

<div>
    PNL: {{ $user->total_pnl }}<br />
    <button wire:click="addAccount">Add Account</button>
    <br />
    @if($accounts)
        @foreach($accounts as $account)
            {{ $account->id }} PNL: {{$account->pnl}} Winning Days: {{ $account->winning_days }} Days
            Traded: {{ $account->days_traded }}
            <button wire:click="logSession('{{$account->id}}')">Log Session</button>
            <button wire:click="removeAccount('{{$account->id}}')">Delete Account</button><br />
            @foreach($account->sessions() as $session)
                {{ $session->pnl }}<br />
                <button
                    wire:click="removeSession('{{$session->id}}', '{{ $session->account_id }}')">
                    X
                </button><br />
            @endforeach
        @endforeach
    @endif
</div>
