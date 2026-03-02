<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'currency',
        'commission_percent', 'category', 'type', 'rating', 'image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}