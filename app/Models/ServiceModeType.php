<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceModeType extends Model
{
    use SoftDeletes;
    protected $fillable = ['name'];

    public function modes()
    {
        return $this->hasMany(ServiceMode::class);
    }
}
