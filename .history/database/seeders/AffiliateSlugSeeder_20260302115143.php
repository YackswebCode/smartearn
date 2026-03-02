<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class AffiliateSlugSeeder extends Seeder
{
    public function run()
    {
        $products = Product::whereNull('affiliate_slug')->get();
        foreach ($products as $product) {
            $product->affiliate_slug = Str::random(8) . '-' . Str::random(4);
            $product->save();
        }
    }
}