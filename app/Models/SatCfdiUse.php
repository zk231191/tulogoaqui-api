<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatCfdiUse extends Model
{
    protected $fillable = [
        'code', 'description', 'active'
    ];

    public function regimes()
    {
        return $this->belongsToMany(
            SatRegime::class,
            'sat_regime_cfdi_uses',
            'cfdi_use_code',
            'regime_code',
            'code',
            'code'
        );
    }
}
