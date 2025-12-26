<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalAddress extends Model
{
    protected $fillable = [
        'customer_id', 'business_name', 'tax_identification_number', 'tax_regime_id', 'cfdi_use_id', 'street', 'external_number', 'internal_number', 'zip_code', 'suburb', 'city', 'state',
    ];
}
