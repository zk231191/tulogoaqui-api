<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderServiceStatus extends Model
{
    protected $fillable = [
        'name', 'label'
    ];

    public function substatus(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderServiceSubstatus::class);
    }
}
