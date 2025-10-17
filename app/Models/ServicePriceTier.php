<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePriceTier extends Model
{
    protected $fillable = [
        'service_size_id',
        'min_qty',
        'max_qty',
        'unit_type',
        'price',
    ];

    public function size()
    {
        return $this->belongsTo(ServiceSize::class);
    }
}
