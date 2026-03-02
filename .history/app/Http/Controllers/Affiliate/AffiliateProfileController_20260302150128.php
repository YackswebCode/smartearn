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
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'business_name' => 'nullable|string|max:255',
            'about_me' => 'nullable|string',
            'business_description' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['currency', 'business_name', 'about_me', 'business_description']);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect()->route('affiliate.edit_profile')->with('success', 'Profile updated successfully.');
    }
}