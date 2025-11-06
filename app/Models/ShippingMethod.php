<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;



class ShippingMethod extends Model
{
    use HasRoles;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'carrier',
        'delivery_time',
        'is_active'
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_shipping_methods');
    }
    public function vendorRates()
    {
        return $this->hasMany(VendorShippingRate::class);
    }
}
