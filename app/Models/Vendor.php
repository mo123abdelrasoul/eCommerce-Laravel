<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'company',
        'status',
        'social_id',
        'social_type',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }
    public function brands()
    {
        return $this->hasMany(Brand::class, 'vendor_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }
    public function shippingRates()
    {
        return $this->hasMany(VendorShippingRate::class);
    }
    public function shippingMethods()
    {
        return $this->belongsToMany(ShippingMethod::class, 'vendor_shipping_methods');
    }
    public function walletTransaction()
    {
        return $this->hasMany(VendorWalletTransaction::class);
    }
    public function withdraw()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
