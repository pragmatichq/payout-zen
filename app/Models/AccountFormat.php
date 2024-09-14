<?php

namespace App\Models;

use App\Enums\AccountFormatTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountFormat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }

    protected function casts(): array
    {
        return [
            'type' => AccountFormatTypeEnum::class,
        ];
    }
}
