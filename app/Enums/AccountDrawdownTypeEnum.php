<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AccountDrawdownTypeEnum: string implements HasLabel, HasColor
{
    case EOD = 'eod';
    case Intraday = 'intraday';
    case Static = 'static';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::EOD => 'End of Day',
            self::Intraday => 'Intraday',
            self::Static => 'Static',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::EOD => 'info',
            self::Intraday => 'danger',
            self::Static => 'success',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
