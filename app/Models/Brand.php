<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;


class Brand extends Model
{
    use SoftDeletes;
    protected $fillable = ["vendor_id", "name", "description", "image", "status", "slug"];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
