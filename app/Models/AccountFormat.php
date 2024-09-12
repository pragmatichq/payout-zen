<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountFormat extends Model
{
    public function firm(): BelongsTo
    {
        return $this->belongsTo(Firm::class);
    }
}
