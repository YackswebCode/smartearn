<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = [
    'buyer_email', 'buyer_name', 'product_id', 'affiliate_id', 'vendor_id',
    'amount', 'currency', 'affiliate_commission', 'vendor_earnings',
    'reference', 'payment_gateway', 'status'
];

    protected $casts = [
        'amount' => 'decimal:2',
        'affiliate_commission' => 'decimal:2',
        'vendor_earnings' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
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