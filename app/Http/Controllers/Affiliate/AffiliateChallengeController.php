<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateChallenge;   // adjust if your model name differs
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateChallengeController extends Controller
{
    public function index(Request $request)
    {
        $userCurrency = Auth::user()->currency;

        // Filter: active / concluded / all
        $status = $request->input('status', 'active'); // default: active

        $query = AffiliateChallenge::query();

        if ($status === 'active') {
            $query->where('end_date', '>=', now())->where('start_date', '<=', now());
        } elseif ($status === 'concluded') {
            $query->where('end_date', '<', now());
        }

        $challenges = $query->with('product.vendor')->orderByDesc('start_date')->get();

        // Map to a clean array for the view (optional)
        $challenges->transform(function ($challenge) {
            $vendorName = $challenge->product->vendor->name ?? 'Unknown Vendor';
            return (object)[
                'id' => $challenge->id,
                'product_name' => $challenge->product->name ?? 'Unknown Product',
                'commission' => $challenge->product->commission_percent ?? 0,
                'vendor_name' => $vendorName,
                'start_date' => $challenge->start_date->format('M d, Y'),
                'end_date' => $challenge->end_date->format('M d, Y'),
                'instructions' => $challenge->instructions,
                'prizes' => $challenge->prizes,
                'status' => $status,
            ];
        });

        return view('affiliate.challenges', compact('challenges', 'status'));
    }
}