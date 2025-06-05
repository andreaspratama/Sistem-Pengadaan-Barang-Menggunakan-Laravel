<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorEvaluation extends Model
{
    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(VendorEvaluationItem::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function orderPerintah()
    {
        return $this->belongsTo(OrderPerintah::class);
    }
}
