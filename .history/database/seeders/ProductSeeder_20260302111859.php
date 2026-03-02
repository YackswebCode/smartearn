<?php
// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Complete Web Development Bootcamp',
                'slug' => 'complete-web-dev-bootcamp',
                'description' => 'Learn HTML, CSS, JavaScript, React, Node.js and more.',
                'price' => 15000.00,
                'currency' => 'NGN',
                'commission_percent' => 20,
                'category' => 'E-learning',
                'type' => 'course',
                'rating' => 5,
                'image' => 'course1.jpg',
            ],
            [
                'name' => 'Digital Marketing Masterclass',
                'slug' => 'digital-marketing-masterclass',
                'description' => 'Master SEO, Social Media, Google Ads and analytics.',
                'price' => 250.00,
                'currency' => 'USD',
                'commission_percent' => 15,
                'category' => 'E-learning',
                'type' => 'course',
                'rating' => 4,
                'image' => 'course2.jpg',
            ],
            [
                'name' => 'The $100 Startup',
                'slug' => '100-startup-ebook',
                'description' => 'E-book on how to start a business with little money.',
                'price' => 9.99,
                'currency' => 'USD',
                'commission_percent' => 30,
                'category' => 'Business',
                'type' => 'ebook',
                'rating' => 5,
                'image' => 'ebook1.jpg',
            ],
            [
                'name' => 'SmartEarn Affiliate Toolkit',
                'slug' => 'smartearn-affiliate-toolkit',
                'description' => 'Exclusive toolkit for affiliates.',
                'price' => 5000.00,
                'currency' => 'NGN',
                'commission_percent' => 10,
                'category' => 'Tools',
                'type' => 'product',
                'rating' => 5,
                'image' => 'toolkit.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}