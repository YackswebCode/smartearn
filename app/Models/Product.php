<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',  'vendor_id', 'slug', 'affiliate_slug', 'description', 'price', 'currency',
        'commission_percent', 'category', 'type', 'rating', 'image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->affiliate_slug)) {
                $product->affiliate_slug = Str::random(8) . '-' . Str::random(4);
            }
        });
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }
}