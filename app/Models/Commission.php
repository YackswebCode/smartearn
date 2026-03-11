<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
   protected $fillable = [
    'order_id', 'affiliate_id', 'vendor_id', 'type', 'amount', 'currency'
];

    protected $casts = ['amount' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


public function affiliate()
{
    return $this->belongsTo(User::class, 'affiliate_id');
}

public function vendor()
{
    return $this->belongsTo(User::class, 'vendor_id');
}
}