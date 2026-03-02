<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'currency',
        'wallet_balance',
        'affiliate_balance',
        'vendor_balance',
        'marketplace_subscribed',
        'subscription_expires_at',
        'vendor_status',
        'profile_image',
        'business_name',
        'about_me',
        'business_description',
        'verification_code',          // <-- added
        'verification_code_expires_at', // <-- added
        'reset_code',                  // optional but good
        'reset_code_expires_at',        // optional
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verification_code_expires_at' => 'datetime',
        'reset_code_expires_at' => 'datetime',
        'subscription_expires_at' => 'datetime',
        'marketplace_subscribed' => 'boolean',
    ];

    // app/Models/User.php
    public function affiliateOrders()
    {
        return $this->hasMany(Order::class, 'affiliate_id');
    }

    public function vendorOrders()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(UserBankAccount::class);
    }
}