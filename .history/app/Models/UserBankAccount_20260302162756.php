<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    protected $fillable = [
        'user_id', 'type', 'bank_name', 'account_name', 'account_number',
        'momo_provider', 'momo_number', 'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}