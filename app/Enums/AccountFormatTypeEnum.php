<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AccountFormatTypeEnum: string implements HasLabel
{
    case Evaluation = 'evaluation';
    case Funded = 'funded';
    case Live = 'live';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Evaluation => 'Evaluation',
            self::Funded => 'Funded',
            self::Live => 'Live',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
