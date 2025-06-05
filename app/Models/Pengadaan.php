<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengadaan extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PengadaanItem::class);
    }

    public function approvalLogs(): HasMany
    {
        return $this->hasMany(ApprovalLog::class);
    }

    public function orderPerintah(): HasOne
    {
        return $this->hasOne(OrderPerintah::class);
    }

    public function evaluasiVendor(): HasOne
    {
        return $this->hasOne(EvaluasiVendor::class);
    }

    public function perintahorders(): HasMany
    {
        return $this->hasMany(Perintahorder::class);
    }
}
