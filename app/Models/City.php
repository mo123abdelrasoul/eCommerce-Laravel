<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class City extends Model
{
    use HasRoles;
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;
    protected $fillable = [
        "name",
        "region_id",
        "is_active",
    ];

    public function Region()
    {
        return $this->belongsTo(ShippingRegion::class, 'region_id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
