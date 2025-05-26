<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function showlogin()
{
    return view('admin.login');
}

    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('admin.login')->with('success', 'Admin registered successfully.');
}

public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    Log::info('Login attempt with email: ' . $request->email);

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        Log::warning('Admin not found for email: ' . $request->email);
        return back()->with('error', 'Admin not found');
    }

    Log::info('Admin found: ' . $admin->email);
    Log::info('Input Password: ' . $request->password);
    Log::info('Stored Hashed Password: ' . $admin->password);

    if (!Hash::check($request->password, $admin->password)) {
        Log::error('Password mismatch for admin: ' . $admin->email);
        return back()->with('error', 'Invalid credentials');
    }

    session(['admin_logged_in' => true, 'admin_id' => $admin->id]);
    Log::info('Admin login successful for: ' . $admin->email);

    return redirect()->route('admin.dashboard');
}


      public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_id']);
        return redirect()->route('admin.login');
    }
}
