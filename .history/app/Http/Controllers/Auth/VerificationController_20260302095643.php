<?php
// app/Http/Controllers/Auth/VerificationController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the verification notice (where user enters the 6-digit code)
     */
    public function show()
    {
        return view('auth.verify');
    }

    /**
     * Verify the submitted code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        // Check if code matches and is not expired
        if ($user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'The code you entered is incorrect.']);
        }

        if ($user->verification_code_expires_at < now()) {
            return back()->withErrors(['code' => 'This code has expired. Please request a new one.']);
        }

        // Mark email as verified and clear the code fields
        $user->email_verified_at = now();
        $user->verification_code = null;
        $user->verification_code_expires_at = null;
        $user->save();

        // Redirect to intended page (e.g., dashboard)
        return redirect()->intended('/affiliate/dashboard');
    }

    /**
     * Resend a new verification code
     */
    public function resend()
    {
        $user = Auth::user();

        // Prevent resend if already verified
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended('/affiliate/dashboard');
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