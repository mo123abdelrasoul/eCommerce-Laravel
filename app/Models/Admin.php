<?php

namespace App\Models;

use App\Notifications\AdminResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    protected $guard_name = 'admins';
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'social_id',
        'social_type',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function isOnline()
    {
        return cache()->has('admin-is-online-' . $this->id);
    }
}
