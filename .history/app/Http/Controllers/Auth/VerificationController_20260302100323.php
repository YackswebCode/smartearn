<?php
// app/Http/Controllers/Auth/VerificationController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{
    /**
     * Show the verification notice (user enters the 6-digit code)
     */
    public function show()
    {
        // If user is already logged in and verified, redirect to dashboard
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect('/affiliate/dashboard');
        }

        // Retrieve email from session
        $email = Session::get('verification_email');

        if (!$email) {
            // No email in session – user might have accessed this page directly
            return redirect()->route('register')
                ->withErrors(['email' => 'Please register first.']);
        }

        return view('auth.verify', compact('email'));
    }

    /**
     * Verify the submitted code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $email = Session::get('verification_email');

        if (!$email) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Session expired. Please register again.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['email' => 'User not found.']);
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            Session::forget('verification_email');
            return redirect()->route('login')
                ->with('success', 'Your email is already verified. Please log in.');
        }

        // Verify code
        if ($user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'The code you entered is incorrect.']);
        }

        if ($user->verification_code_expires_at < now()) {
            return back()->withErrors(['code' => 'This code has expired. Please request a new one.']);
        }

        // Mark email as verified and clear code fields
        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->save();

        // Clear the session email
        Session::forget('verification_email');

        // Redirect to login page with success message
        return redirect()->route('login')
            ->with('success', 'Email verified successfully! You can now log in.');
    }

    /**
     * Resend a new verification code
     */
    public function resend()
    {
        $email = Session::get('verification_email');

        if (!$email) {
            return redirect()->route('register')
                ->withErrors(['email' => 'Session expired. Please register again.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('register')
                ->withErrors(['email' => 'User not found.']);
        }

        if ($user->hasVerifiedEmail()) {
            Session::forget('verification_email');
            return redirect()->route('login')
                ->with('success', 'Email already verified. Please log in.');
        }

        // Generate new code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->verification_code = $code;
        $user->verification_code_expires_at = now()->addMinutes(10);
        $user->save();

        // Send new code
        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));

        return back()->with('resent', true);
    }
}