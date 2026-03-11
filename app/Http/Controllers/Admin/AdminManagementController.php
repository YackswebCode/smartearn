<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.form', [
            'admin' => new Admin(),
            'formAction' => route('admin.admins.store'),
            'formMethod' => 'POST',
            'buttonText' => 'Create Admin'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('admins', 'public');
        }

        Admin::create($data);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.admins.form', [
            'admin' => $admin,
            'formAction' => route('admin.admins.update', $admin),
            'formMethod' => 'POST',
            'buttonText' => 'Update Admin'
        ]);
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($admin->profile_image) {
                \Storage::disk('public')->delete($admin->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('admins', 'public');
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        // Prevent self-deletion
        if ($admin->id === Auth::guard('admin')->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        // Delete profile image if exists
        if ($admin->profile_image) {
            \Storage::disk('public')->delete($admin->profile_image);
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }
}