<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicProductController extends Controller
{
    // Conversion rates to NGN
    protected $toNGN = [
        'NGN' => 1,
        'USD' => 1363.33,
        'GHS' => 127.81,
        'XAF' => 2.45,
        'KES' => 10.56,
    ];

    // Currency symbols
    protected $symbols = [
        'NGN' => '₦',
        'USD' => '$',
        'GHS' => 'GH¢',
        'XAF' => 'FCFA',
        'KES' => 'KES',
    ];

   public function show($affiliateId, $productSlug)
{
    $affiliate = User::findOrFail($affiliateId);
    $product = Product::where('affiliate_slug', $productSlug)->firstOrFail();

    return view('affiliate.public-product', [
        'product' => $product,
        'affiliate' => $affiliate,
        'toNGN' => $this->toNGN,
        'symbols' => $this->symbols,
        'baseUrl' => config('app.url'),
    ]);
}
}