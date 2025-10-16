<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;
    public function Region()
    {
        return $this->belongsTo(ShippingRegion::class, 'region_id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
