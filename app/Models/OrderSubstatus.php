<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSubstatus extends Model
{
    protected $fillable = [
        'name', 'label', 'status_id'
    ];

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
