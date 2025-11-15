<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceMode extends Model
{
    protected $fillable = ['service_id', 'type_id', 'name', 'description'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function type()
    {
        return $this->belongsTo(ServiceModeType::class, 'type_id');
    }

    public function prices()
    {
        return $this->hasMany(ServicePriceTier::class);
    }
}
