<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class OrderItem extends Model
{
    use HasRoles;
    use SoftDeletes;
    protected $fillable = [
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'total_price',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
