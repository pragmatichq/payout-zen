<?php

namespace App\Filament\Resources\AccountResource\Widgets;

use App\Models\Account;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AccountBalanceOverTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Balance over time';

    protected static ?string $pollingInterval = '1s';

    public Account $record;

    protected function getData(): array
    {
        $sessions = $this->record->sessions()->orderBy('date')->get();

        // Initialize cumulative balance with the account's starting balance
        $startingBalance = $this->record->starting_balance / 100;
        $cumulativeBalance = $startingBalance;

        // Prepare arrays for cumulative PnL (data) and session dates (labels)
        $data = [];
        $labels = [];

        foreach ($sessions as $session) {
            // Update cumulative balance by adding the session's PnL
            $cumulativeBalance += ($session->pnl / 100);

            // Append cumulative balance to data and session date to labels
            $data[] = $cumulativeBalance;
            $labels[] = $session->date->format('m-d-Y');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Balance over time',
                    'data' => $data,
                ],
            ],

            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(/** @lang text */ <<<JS
        {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';

                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                        return new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD'
                        }).format(value);
                    }
                    },
                },
            },
        }
    JS
        );
    }
}
