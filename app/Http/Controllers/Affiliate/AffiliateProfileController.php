<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AffiliateProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('affiliate.edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'currency'             => 'required|in:NGN,USD,GHS,XAF,KES',
            'business_name'        => 'nullable|string|max:255',
            'about_me'             => 'nullable|string|max:1000',
            'business_description' => 'nullable|string|max:2000',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // Update other fields
        $user->currency             = $request->currency;
        $user->business_name        = $request->business_name ?? $user->name;
        $user->about_me             = $request->about_me;
        $user->business_description = $request->business_description;
        $user->save();

        return redirect()->route('affiliate.edit_profile')
            ->with('success', 'Profile updated successfully.');
    }
}