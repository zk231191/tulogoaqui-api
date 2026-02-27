<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'sat_product_code',
        'sat_unit_code',
        'sat_tax_object',
        'active'
    ];

    public function modes()
    {
        return $this->hasMany(ServiceMode::class);
    }
}
