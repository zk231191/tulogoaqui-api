<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatRegimeCfdiUse extends Model
{
    protected $fillable = [
        'regime_code', 'cfdi_use_code'
    ];
}
