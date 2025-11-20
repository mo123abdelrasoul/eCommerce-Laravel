<?php

namespace App\Models;

use App\Notifications\VendorResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class Vendor extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, SoftDeletes;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new class extends VerifyEmail {
            protected function verificationUrl($notifiable)
            {
                return URL::temporarySignedRoute(
                    'vendor.verification.verify',
                    now()->addMinutes(60),
                    [
                        'id' => $notifiable->getKey(),
                        'hash' => sha1($notifiable->getEmailForVerification()),
                        'lang' => app()->getLocale()
                    ]
                );
            }
            public function toMail($notifiable)
            {
                return (new MailMessage)
                    ->subject('Verify Email Address (Vendor)')
                    ->line('Click the button below to verify your email address.')
                    ->action('Verify Email Address', $this->verificationUrl($notifiable))
                    ->line('If you did not create an account, no further action is required.');
            }
        });
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'company',
        'status',
        'social_id',
        'social_type',
    ];
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new VendorResetPassword($token));
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }
    public function brands()
    {
        return $this->hasMany(Brand::class, 'vendor_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }
    public function shippingRates()
    {
        return $this->hasMany(VendorShippingRate::class);
    }
    public function shippingMethods()
    {
        return $this->belongsToMany(ShippingMethod::class, 'vendor_shipping_methods');
    }
    public function walletTransaction()
    {
        return $this->hasMany(VendorWalletTransaction::class);
    }
    public function withdraw()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function getWalletBalance()
    {
        $credits = $this->walletTransaction()->where('type', 'credit')->sum('amount');
        $debits = $this->walletTransaction()->where('type', 'debit')->sum('amount');
        return $credits + $debits;
    }

    public function isOnline()
    {
        return cache()->has('vendor-is-online-' . $this->id);
    }
}
