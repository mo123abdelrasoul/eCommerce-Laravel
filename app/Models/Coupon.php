<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class Coupon extends Model
{
    use HasRoles;
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_order_amount',
        'max_order_amount',
        'usage_limit',
        'usage_limit_per_user',
        'applies_to_all_products',
        'applies_to_all_categories',
        'excluded_product_ids',
        'excluded_category_ids',
        'status',
        'start_date',
        'end_date',
        'vendor_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function couponUser()
    {
        return $this->hasMany(CouponUser::class);
    }
}
