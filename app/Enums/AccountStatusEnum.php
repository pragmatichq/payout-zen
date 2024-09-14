<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AccountStatusEnum: string implements HasLabel, HasColor
{
    case Active = 'active';
    case Failed = 'failed';
    case Passed = 'passed';
    case Reset = 'reset';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Failed => 'Failed',
            self::Passed => 'Passed',
            self::Reset => 'Reset',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'info',
            self::Failed => 'danger',
            self::Passed => 'success',
            self::Reset => 'gray',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
