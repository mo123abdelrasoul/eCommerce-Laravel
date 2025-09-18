<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'status',
        'payment_method',
        'shipping_cost',
        'shipping_address',
        'notes',
        'total_amount'
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function order()
    {
        return $this->belongsTo(ShippingMethod::class);
    }
}
