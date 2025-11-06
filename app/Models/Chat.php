<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class Chat extends Model
{
    use HasRoles;
    protected $fillable = [
        'vendor_id',
        'admin_id',
        'last_message_at',
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
