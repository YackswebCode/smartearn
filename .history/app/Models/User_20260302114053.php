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
        'verification_code',
        'verification_code_expires_at',
        'wallet_balance', 'affiliate_balance', 'vendor_balance',
        'marketplace_subscribed', 'subscription_expires_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verification_code_expires_at' => 'datetime',
        'reset_code_expires_at' => 'datetime',
        'subscription_expires_at' => 'datetime', // <-- add this line
        'marketplace_subscribed' => 'boolean',
    ];
}
