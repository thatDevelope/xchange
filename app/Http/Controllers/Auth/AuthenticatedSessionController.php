<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Wallet;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::check() && !Auth::user()->wallet) {
            Wallet::create([
                'user_id' => Auth::id(),
                'wallet_id' => Str::uuid(),
                'type' => 'main',
                'balance' => 0,
            ]);
        }

        // Get currency order count for the logged-in user
    $orderCount = \App\Models\CurrencyOrder::where('user_id', Auth::id())->count();

    // Store it in session to use later in your dashboard
    session(['orderCount' => $orderCount]);

        return redirect()->intended(route('userdash', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
