<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AccountFormatTypeEnum: string implements HasLabel, HasColor
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

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Evaluation => 'warning',
            self::Funded => 'success',
            self::Live => 'info',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
