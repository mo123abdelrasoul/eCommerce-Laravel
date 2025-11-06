<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Brand extends Model
{
    use HasRoles;
    use SoftDeletes;
    protected $fillable = ["vendor_id", "name", "description", "image", "status", "slug"];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
