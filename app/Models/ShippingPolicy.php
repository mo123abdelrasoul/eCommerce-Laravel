<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingPolicy extends Model
{
    use HasFactory;
    public function rates()
    {
        return $this->hasMany(ShippingRate::class);
    }
    public function methods()
    {
        return $this->hasMany(ShippingMethod::class);
    }
}
