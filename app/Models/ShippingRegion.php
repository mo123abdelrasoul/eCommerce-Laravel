<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingRegion extends Model
{
    use HasFactory;
    public function rates()
    {
        return $this->hasMany(ShippingRate::class);
    }
    public function cities()
    {
        return $this->hasMany(City::class, 'region_id');
    }
}
