<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    protected $guard_name = 'admins';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'social_id',
        'social_type',
    ];
}
