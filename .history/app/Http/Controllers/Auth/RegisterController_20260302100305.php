<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'terms'    => 'accepted',
        ]);

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name'                         => $request->name,
            'email'                        => $request->email,
            'password'                      => Hash::make($request->password),
            'verification_code'             => $code,
            'verification_code_expires_at'  => now()->addMinutes(10),
        ]);

        // Send the code via email
        Mail::to($user->email)->send(new VerificationCodeMail($user, $code));

        // Store email in session to identify user during verification
        Session::put('verification_email', $user->email);

        // Redirect to verification page (not logged in)
        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email for the verification code.');
    }
}