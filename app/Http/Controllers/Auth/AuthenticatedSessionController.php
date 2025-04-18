<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login_sneat');
    }
    public function createWali(): View
    {
        return view('auth.login_sneat_wali');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate user
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Check the user role and redirect accordingly
        if ($user->akses === 'operator' || $user->akses === 'admin') {
            return redirect()->route('operator.beranda');
        } elseif ($user->akses === 'wali') {
            return redirect()->route('wali.beranda');
        } else {
            // Logout user if no valid role
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki hak akses');
        }
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
