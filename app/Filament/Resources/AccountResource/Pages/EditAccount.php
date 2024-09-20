<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use App\Filament\Resources\AccountResource\Widgets\AccountBalanceOverTimeChart;
use App\Filament\Resources\AccountResource\Widgets\AccountOverview;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AccountBalanceOverTimeChart::class,
            AccountOverview::class
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 2;
    }

    #[On('refreshForm')]
    public function refreshForm(): void
    {
        parent::fillForm();
    }
}
