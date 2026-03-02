<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Track;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkillGarageController extends Controller
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

    public function index()
    {
        $faculties = Faculty::orderBy('order')->get();
        return view('affiliate.skill_garage', compact('faculties'));
    }

    public function showFaculty($id)
    {
        $faculty = Faculty::with('tracks')->findOrFail($id);
        return view('affiliate.skill_garage_faculty', compact('faculty'));
    }

public function showTrack($id)
{
    $track = Track::with('faculty')->findOrFail($id);
    $user = Auth::user();
    $userCurrency = $user->currency;
    $toNGN = $this->toNGN;
    $symbols = $this->symbols;

    // Check if user already enrolled
    $enrollment = Enrollment::where('user_id', $user->id)
        ->where('track_id', $track->id)
        ->where('status', 'active')
        ->first();

    // Convert prices only if not enrolled
    $prices = [];
    if (!$enrollment) {
        foreach (['monthly', 'quarterly', 'yearly'] as $plan) {
            $priceField = "price_$plan";
            if ($track->$priceField) {
                $priceInNGN = $track->$priceField * $this->toNGN[$track->currency];
                $priceInUser = $priceInNGN / $this->toNGN[$userCurrency];
                $prices[$plan] = [
                    'amount' => $priceInUser,
                    'formatted' => $symbols[$userCurrency] . number_format($priceInUser, 2)
                ];
            }
        }
    }

    return view('affiliate.skill_garage_track', compact('track', 'prices', 'userCurrency', 'symbols', 'toNGN', 'enrollment'));
}

    public function enroll(Request $request, $trackId)
    {
        $request->validate([
            'plan' => 'required|in:monthly,quarterly,yearly',
        ]);

        $user = Auth::user();
        $track = Track::findOrFail($trackId);
        $userCurrency = $user->currency;

        // Get price in user's currency
        $priceField = "price_$request->plan";
        $priceInTrackCurrency = $track->$priceField;
        $priceInNGN = $priceInTrackCurrency * $this->toNGN[$track->currency];
        $priceInUserCurrency = $priceInNGN / $this->toNGN[$userCurrency];

        // Check wallet balance (wallet is in NGN)
        $walletBalanceNGN = $user->wallet_balance; // wallet_balance is in NGN
        $requiredNGN = $priceInNGN;

        if ($walletBalanceNGN < $requiredNGN) {
            return back()->with('error', 'Insufficient wallet balance. Please add funds.');
        }

        DB::beginTransaction();

        try {
            // Deduct from wallet
            $user->wallet_balance -= $requiredNGN;
            $user->save();

            // Create enrollment
            $enrollment = Enrollment::create([
                'user_id' => $user->id,
                'track_id' => $track->id,
                'plan' => $request->plan,
                'amount_paid' => $priceInUserCurrency,
                'currency' => $userCurrency,
                'status' => 'active',
                'start_date' => now(),
                'end_date' => $request->plan == 'yearly' ? now()->addYear() : now()->addMonths(3),
            ]);

            DB::commit();

            return redirect()->route('affiliate.skill_garage.track', $track->id)
                ->with('success', 'Enrollment successful! You can now access your course materials.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Enrollment failed: ' . $e->getMessage());
        }
    }
}