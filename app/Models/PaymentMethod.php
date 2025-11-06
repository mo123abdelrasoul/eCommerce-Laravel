<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class PaymentMethod extends Model
{
    use HasRoles;
    use SoftDeletes;
}
