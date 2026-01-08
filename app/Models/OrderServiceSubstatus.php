<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderServiceSubstatus extends Model
{
    protected $fillable = [
        'name', 'label', 'order_service_status_id'
    ];

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderServiceStatus::class);
    }
}
