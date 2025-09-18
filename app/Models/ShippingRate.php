<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;
    public function region()
    {
        return $this->belongsTo(ShippingRegion::class);
    }
    public function policy()
    {
        return $this->belongsTo(ShippingPolicy::class);
    }
}
