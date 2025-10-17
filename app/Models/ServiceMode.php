<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceMode extends Model
{
    protected $fillable = ['service_id', 'name', 'description', 'includes_ironing'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function sizes()
    {
        return $this->hasMany(ServiceSize::class);
    }
}
