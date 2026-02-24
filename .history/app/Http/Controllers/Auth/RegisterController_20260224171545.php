<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Show register page (design only)
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle form submission (design-only)
     * Redirect to verify page
     */
    public function register(Request $request)
    {
        // Optional: you can flash some data to session if you want to display on verify page
        // session()->flash('email', $request->email);

        return redirect('/verify');
    }
}