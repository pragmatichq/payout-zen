<?php

use App\Events\AccountCreated;
use App\Models\Account;
use App\Models\User;
use App\States\AccountState;
use App\States\UserState;
use Livewire\Volt\Component;
use Thunk\Verbs\Support\StateCollection;

new class extends Component {
    public function with(): array
    {
        return [
            'accounts' => User::find(Auth::id())->accounts
        ];
    }

    public function CreateAccount(): void
    {
        AccountCreated::fire(user_id: Auth::id());
    }


}; ?>

<div>
    <button wire:click="CreateAccount">Create Account</button>
    <br />
    @foreach($accounts as $account)
        {{$account->id}}<br />
    @endforeach
</div>
