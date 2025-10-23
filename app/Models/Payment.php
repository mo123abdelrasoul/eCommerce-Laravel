<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'customer_id',
        'gateway',
        'transaction_id',
        'reference',
        'amount_cents',
        'currency',
        'status',
    ];
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_payments', 'payment_id', 'order_id')->withTimestamps();
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
