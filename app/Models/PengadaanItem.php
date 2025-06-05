<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengadaanItem extends Model
{
    protected $guarded = [];

    public function pengadaan(): BelongsTo
    {
        return $this->belongsTo(Pengadaan::class);
    }

    public function vendorOffers()
    {
        return $this->hasMany(VendorOffer::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function poitem(): HasMany
    {
        return $this->hasMany(PerintahorderItem::class);
    }
}
