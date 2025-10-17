<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSize extends Model
{
    protected $fillable = ['service_mode_id', 'name', 'width_cm', 'height_cm'];

    public function mode()
    {
        return $this->belongsTo(ServiceMode::class, 'service_mode_id');
    }

    public function priceTiers()
    {
        return $this->hasMany(ServicePriceTier::class);
    }
}
