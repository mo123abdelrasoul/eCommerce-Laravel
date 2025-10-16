<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
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
}
