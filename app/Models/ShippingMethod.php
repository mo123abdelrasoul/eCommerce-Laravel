<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ShippingMethod extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'price', "vendor_id", "delivery_time", 'status'];

    public function vendor()
    {
        return $this->BelongsTo(Vendor::class, 'vendor_id');
    }
}
