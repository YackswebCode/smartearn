<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Show login page (design only)
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Fake login (no authentication)
     */
    public function login(Request $request)
    {
        // Just redirect somewhere without validating
        return redirect('/affiliate/dashboard');
    }

    /**
     * Fake logout
     */
    public function logout()
    {
        return redirect('/');
    }
}