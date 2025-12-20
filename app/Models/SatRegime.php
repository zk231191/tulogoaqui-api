<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatRegime extends Model
{
    protected $fillable = [
        'code', 'description', 'active'
    ];

    public function cfdiUses()
    {
        return $this->belongsToMany(
            SatCFDIUse::class,
            'sat_regime_cfdi_uses',
            'regime_code',
            'cfdi_use_code',
            'code',
            'code'
        );
    }
}
