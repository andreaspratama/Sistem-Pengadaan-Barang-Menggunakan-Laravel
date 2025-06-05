<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorOffer extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->belongsTo(PengadaanItem::class, 'pengadaan_item_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
