<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Formvendor extends Model
{
    protected $guarded = [];

    public function perintahorders(): HasMany
    {
        return $this->hasMany(Perintahorder::class);
    }
}
