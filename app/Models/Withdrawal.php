<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class Withdrawal extends Model
{
    use HasRoles;
    protected $fillable = [
        'vendor_id',
        'amount',
        'notes',
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
