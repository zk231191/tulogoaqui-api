<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'paternal_last_name',
        'maternal_last_name',
        'phone',
        'email',
        'facture_required',
        'email_verified_at'
    ];

    protected $casts = [
        'facture_required' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function address()
    {
        return $this->hasOne(FiscalAddress::class)->whereNull('deleted_at');
    }

    protected static function boot()
    {
        parent::boot();

        static::restored(function ($customer) {
            if (!$customer->address()->exists()) {
                $old = $customer->hasMany(FiscalAddress::class)->withTrashed()->latest('id')->first();
                $old?->restore();
            }
        });
    }
}