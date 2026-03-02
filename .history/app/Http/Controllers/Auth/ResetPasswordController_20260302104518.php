<?php
// app/Http/Controllers/Auth/ResetPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        // Check if we have an email in session
        if (!Session::has('reset_email')) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Please request a password reset first.']);
        }

        return view('auth.passwords.reset', [
            'email' => Session::get('reset_email')
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::where('email', $request->email)->first();

        // Verify code
        if ($user->reset_code !== $request->code) {
            return back()->withErrors(['code' => 'The reset code is incorrect.']);
        }

        if ($user->reset_code_expires_at < now()) {
            return back()->withErrors(['code' => 'This reset code has expired. Please request a new one.']);
        }

        // Update password and clear reset fields
        $user->password = Hash::make($request->password);
        $user->reset_code = null;
        $user->reset_code_expires_at = null;
        $user->save();

        // Clear the session email
        Session::forget('reset_email');

        // Redirect to login with success message
       return redirect()->route('login')
            ->with('success', 'Your password has been reset! You can now log in with your new password.');
    }
}