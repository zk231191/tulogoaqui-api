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
        'last_name',
        'phone',
        'email'
    ];

    public function address()
    {
        return $this->hasOne(FiscalAddress::class);
    }
    
    public static function boot()
    {
        parent::boot();

        static::restored(function ($customer) {
            $customer->address()->withTrashed()->restore();
        });
    }
}

?>