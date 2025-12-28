<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class ShippingRegion extends Model
{
    use HasRoles;
    use HasFactory;
    protected $fillable = ['name', 'description', 'is_active'];
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function cities()
    {
        return $this->hasMany(City::class, 'region_id');
    }

    public function vendorRates()
    {
        return $this->hasMany(VendorShippingRate::class);
    }
}
