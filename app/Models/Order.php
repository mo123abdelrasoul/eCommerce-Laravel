<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'order_number',
        'status',
        'total_amount',
        'payment_status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'shipping_cost',
        'total_weight',
        'discount_amount',
        'tax_amount',
        'notes',
        'vendor_id',
        'sub_total',
        'shipping_method_id',
        'coupon_id',
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'order_payments', 'order_id', 'payment_id')->withTimestamps();
    }
    public function vendorTransactions()
    {
        return $this->hasMany(VendorWalletTransaction::class);
    }
}
