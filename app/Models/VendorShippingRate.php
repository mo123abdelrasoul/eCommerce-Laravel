<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class VendorShippingRate extends Model
{
    use HasRoles;
    protected $fillable = [
        'vendor_id',
        'shipping_method_id',
        'shipping_region_id',
        'min_weight',
        'max_weight',
        'rate',
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function method()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }

    public function region()
    {
        return $this->belongsTo(ShippingRegion::class, 'shipping_region_id');
    }
}
