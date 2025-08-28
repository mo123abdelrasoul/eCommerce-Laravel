<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'company',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }
    public function brands()
    {
        return $this->hasMany(Brand::class, 'vendor_id');
    }
}
