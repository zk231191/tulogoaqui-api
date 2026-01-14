<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalAddress extends Model
{
    protected $fillable = [
        'customer_id', 'business_name', 'tax_identification_number', 'tax_regime_id', 'email', 'street', 'external_number', 'internal_number', 'zip_code', 'suburb', 'city', 'state',
    ];

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function regime(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SatRegime::class, 'tax_regime_id');
    }
}
