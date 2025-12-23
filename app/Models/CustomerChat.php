<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class CustomerChat extends Model
{
    use HasRoles;
    protected $fillable = [
        'user_id',
        'admin_id',
        'last_message',
        'last_message_at',
        'is_read'
    ];
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
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
