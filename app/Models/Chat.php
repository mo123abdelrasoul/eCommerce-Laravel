<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
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
