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
    public function shipping()
    {
        return $this->hasMany(Shipping::class, 'vendor_id');
    }
}
