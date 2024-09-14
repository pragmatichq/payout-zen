<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Firm extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function account_formats(): HasMany
    {
        return $this->hasMany(AccountFormat::class);
    }

}
