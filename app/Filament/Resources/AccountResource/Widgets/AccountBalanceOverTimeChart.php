<?php

namespace App\Filament\Resources\AccountResource\Widgets;

use App\Models\Account;
use Filament\Widgets\ChartWidget;

class AccountBalanceOverTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Balance over time';

    public Account $record;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Balance over time',
                    'data' => [0, 1, 2]
                ],
            ],

            'labels' => ["0", "1", "2"]
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
