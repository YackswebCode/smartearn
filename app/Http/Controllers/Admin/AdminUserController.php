<?php
// app/Http/Controllers/Admin/AdminUserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'business_name' => 'nullable|string|max:255',
            'about_me' => 'nullable|string',
            'business_description' => 'nullable|string',
            'currency' => 'required|in:NGN,USD,GHS,XAF,KES',
            'vendor_status' => 'required|in:Not_Yet,Pending,Active,Reject',
            'activation_paid' => 'boolean',
            'is_banned' => 'boolean',
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = !$user->is_banned; // toggle
        $user->save();

        $status = $user->is_banned ? 'banned' : 'unbanned';
        return back()->with('success', "User has been {$status}.");
    }
}