<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{
    protected $fillable = [
        'order_id',
        'order_service_id',
        'from_status_id',
        'to_status_id',
        'from_substatus_id',
        'to_substatus_id',
        'user_id',
        'comment',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderService()
    {
        return $this->belongsTo(OrderService::class);
    }

    public function fromStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'from_status_id');
    }

    public function toStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'to_status_id');
    }

    public function fromSubstatus()
    {
        return $this->belongsTo(OrderSubstatus::class, 'from_substatus_id');
    }

    public function toSubstatus()
    {
        return $this->belongsTo(OrderSubstatus::class, 'to_substatus_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
