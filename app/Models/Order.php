<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'seller_id', 'customer_id', 'fiscal_address_id', 'require_invoice', 'cfdi_use_code', 'subtotal', 'discount', 'tax', 'total', 'paid_amount', 'pending_amount', 'comments'
    ];

    public function services(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderService::class);
    }
}
