<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderServiceItem extends Model
{
    protected $fillable = [
        'order_service_id', 'service_mode_price_id', 'order_substatus_id', 'quantity', 'unit_price', 'subtotal',
    ];

    public function orderService(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderService::class);
    }

    public function price(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ServicePriceTier::class, 'service_mode_price_id');
    }
}
