<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/affiliate/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * The user has been authenticated.
     * Check email verification and activation payment.
     */
    protected function authenticated(Request $request, $user)
    {
        // First check if email is verified
        if (!$user->hasVerifiedEmail()) {
            auth()->logout();
            return redirect()->route('verification.notice')
                ->withErrors(['email' => 'You need to verify your email address. A code has been sent to your email.']);
        }

        // Then check if activation fee is paid
        if (!$user->activation_paid) {
            auth()->logout();
            // Store email in session for payment page
            session(['email' => $user->email]);
            return redirect()->route('subscription.payment')
                ->withErrors(['payment' => 'You need to pay the activation fee before accessing your account.']);
        }

        // All checks passed – proceed to dashboard
        return redirect()->intended($this->redirectTo);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}