<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    protected $guarded = [];

    public function firms(): BelongsToMany
    {
        return $this->belongsToMany(Firm::class);
    }
}
