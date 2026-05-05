<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect (fallback only)
     */
    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * After login logic
     */
    protected function authenticated(Request $request, $user)
    {
        // 🔒 Ensure email is verified
        if (!$user->hasVerifiedEmail()) {
            auth()->logout();

            return redirect()->route('verification.notice')
                ->withErrors([
                    'email' => 'You need to verify your email address. A code has been sent to your email.'
                ]);
        }

        // 🎯 Redirect based on account type
        if ($user->account_type === 'ecommerce') {
            return redirect()->route('customer.dashboard');
        }

        if ($user->account_type === 'edtech') {
            return redirect()->route('affiliate.digital_university');
        }

        // ⚠️ Fallback (in case account_type is null or invalid)
        return redirect('/login');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}