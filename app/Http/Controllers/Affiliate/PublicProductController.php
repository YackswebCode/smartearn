<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    protected $toNGN = [
        'NGN' => 1,
        'USD' => 1363.33,
        'GHS' => 127.81,
        'XAF' => 2.45,
        'KES' => 10.56,
    ];

    protected $symbols = [
        'NGN' => '₦',
        'USD' => '$',
        'GHS' => 'GH¢',
        'XAF' => 'FCFA',
        'KES' => 'KES',
    ];

    /**
     * Show the public product page.
     *
     * Handles both:
     *   /p/{slug}                        (vendor sale)
     *   /aff/{affiliateId}/{productSlug} (affiliate sale)
     */
    public function show(Request $request, $param1, $param2 = null)
    {
        // Determine which route is being used
        if ($param2) {
            // Affiliate route: /aff/{affiliateId}/{productSlug}
            $affiliateId = $param1;
            $slug = $param2;

            // Fetch the affiliate user (any user can be an affiliate)
            $affiliate = User::findOrFail($affiliateId);

            $ref = 'affiliate_' . $affiliate->id;
        } else {
            // Vendor route: /p/{slug}
            $slug = $param1;
            $affiliateId = null;
            $affiliate = null;

            // Optional tracking ref from query string (?ref=creator_18)
            $ref = $request->query('ref', 'creator_unknown');
        }

        $product = Product::where('slug', $slug)->firstOrFail();
        $vendor = $product->vendor;

        // Pass conversion rates and symbols to the views
        $toNGN = $this->toNGN;
        $symbols = $this->symbols;

        // Choose the appropriate view based on whether it's an affiliate link or vendor link
        $view = $affiliateId ? 'product.affiliate' : 'product.vendor';

        return view($view, compact(
            'product',
            'vendor',
            'affiliate',
            'ref',
            'toNGN',
            'symbols'
        ));
    }
}