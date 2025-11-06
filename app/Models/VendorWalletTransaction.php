<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class VendorWalletTransaction extends Model
{
    use HasRoles;
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'order_id',
        'amount',
        'type',
        'description',
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
