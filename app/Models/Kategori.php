<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $guarded = [];

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PengadaanItem::class);
    }
}
