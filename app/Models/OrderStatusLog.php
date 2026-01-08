<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{
    protected $fillable = [
        'order_id',
        'order_service_id',
        'from_order_service_status_id',
        'to_order_service_status_id',
        'from_order_service_substatus_id',
        'to_order_service_substatus_id',
        'user_id',
        'comment',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderService(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderService::class);
    }

    public function fromStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderServiceStatus::class, 'from_order_service_status_id');
    }

    public function toStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderServiceStatus::class, 'to_order_service_status_id');
    }

    public function fromSubstatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderServiceSubstatus::class, 'from_order_service_substatus_id');
    }

    public function toSubstatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderServiceSubstatus::class, 'to_order_service_substatus_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
