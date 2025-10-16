<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ShippingMethod extends Model
{
    use HasFactory;
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function policy()
    {
        return $this->belongsTo(ShippingPolicy::class, 'shipping_policy_id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
