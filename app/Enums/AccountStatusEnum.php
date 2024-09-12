<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AccountStatusEnum: string implements HasLabel
{
    case Active = 'active';
    case Failed = 'failed';
    case Passed = 'passed';
    case Reset = 'reset';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Failed => 'Funded',
            self::Passed => 'Live',
            self::Reset => 'Reset',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
