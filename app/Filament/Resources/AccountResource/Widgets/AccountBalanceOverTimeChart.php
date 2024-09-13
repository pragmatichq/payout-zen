<?php

namespace App\Filament\Resources\AccountResource\Widgets;

use App\Models\Account;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class AccountBalanceOverTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Balance over time';

    public Account $record;

    public $balance_over_time;

    protected function getData(): array
    {
        $this->balance_over_time = $this->record->balance_over_time;
        return [
            'datasets' => [
                [
                    'label' => 'Balance over time',
                    'data' => $this->balance_over_time['values']
                ],
            ],

            'labels' => $this->balance_over_time['dates'],
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
                        // Format the value with commas and currency symbol
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
