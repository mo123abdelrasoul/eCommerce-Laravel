<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;


class Product extends Model
{
    use HasRoles;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'description', "image", "tags", 'price', 'quantity', 'category_id', 'brand_id', 'vendor_id', 'status', 'sku', 'discount', 'admin_feedback'];


    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function orderItems()
    {
        return $this->hasMany(Order::class, 'product_id');
    }
}
