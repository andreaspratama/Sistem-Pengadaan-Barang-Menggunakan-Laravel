<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorEvaluationItem extends Model
{
    public function evaluation()
    {
        return $this->belongsTo(VendorEvaluation::class, 'vendor_evaluation_id');
    }
}
