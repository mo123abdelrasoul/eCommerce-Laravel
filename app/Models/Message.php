<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_type',
        'sender_id',
        'message',
        'is_read',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
    public function sender()
    {
        return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    }
}
