<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePriceTier extends Model
{
    protected $fillable = [
        'service_mode_id',
        'name',
        'description',
        'min_qty',
        'max_qty',
        'price',
    ];
    public function mode()
    {
        return $this->belongsTo(ServiceMode::class);
    }
}
