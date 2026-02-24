<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateProfileController extends Controller
{
    /**
     * Show the edit profile form.
     */
    public function edit()
    {
        // Get the authenticated user (or affiliate)
        $user = Auth::user();

        // Dummy data – replace with actual database fetch from affiliate_profiles table or user meta
        $profile = (object) [
            'currency'            => 'USD',
            'business_name'       => 'Awonusi Temitope',
            'about_me'            => "Awonusi Temitope is a 6 Figure Website Designer\r\ni am the originator of the Course Website To Millions\r\n",
            'business_description' => "Website to Millions is course that's is birth out of hunger to see youth thrive online and also get liberated financially through designing high responsive website for high paying clients",
        ];

        return view('affiliate.edit_profile', compact('profile'));
    }

    /**
     * Update the affiliate profile.
     */
    public function update(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'currency'     => 'required|string|max:10',
            'business_name'=> 'required|string|max:255',
            'about_me'     => 'nullable|string',
            'business_description' => 'nullable|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // TODO: Save to database – adjust according to your schema
        // Example: $user->affiliateProfile()->update($validated);
        // Or if using a dedicated model: AffiliateProfile::updateOrCreate(['user_id' => $user->id], $validated);

        // Redirect back with success message
        return redirect()->route('affiliate.profile.edit')
                         ->with('success', 'Profile updated successfully.');
    }
}