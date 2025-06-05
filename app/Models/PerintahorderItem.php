<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerintahorderItem extends Model
{
    protected $guarded = [];

    public function perintahorder()
    {
        return $this->belongsTo(Perintahorder::class);
    }

    public function items()
    {
        return $this->belongsTo(PengadaanItem::class, 'pengadaan_item_id');
    }
}
