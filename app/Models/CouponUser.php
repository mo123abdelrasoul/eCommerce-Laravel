<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class CouponUser extends Model
{
    use HasRoles;
    use SoftDeletes;
    protected $fillable = [
        'coupon_id',
        'user_id',
        'times_used',
    ];
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
