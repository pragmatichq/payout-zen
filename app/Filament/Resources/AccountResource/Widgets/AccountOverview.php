<?php

namespace App\Filament\Resources\AccountResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class AccountOverview extends BaseWidget
{

    protected int|string|array $columnSpan = '1';
    protected static ?string $pollingInterval = '1s';

    public ?Model $record = null;

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Current Balance', "$" . number_format($this->record->current_balance / 100)),
            Stat::make('Profit and Loss', "$" . number_format($this->record->pnl / 100)),
            Stat::make('Distance from Goal', "$" . number_format($this->record->distance_from_profit_goal / 100)),
            Stat::make('Distance from Drawdown', "$" . number_format($this->record->drawdown_remaining / 100)),
        ];
    }
}
