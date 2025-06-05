<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    protected $guarded = [];

    public function perintahorders(): HasMany
    {
        return $this->hasMany(Perintahorder::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function vendorOffers()
    {
        return $this->hasMany(VendorOffer::class);
    }
}
