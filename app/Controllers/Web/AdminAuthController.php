<?php

namespace App\Controllers\Web;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController
{
    public function login(): View
    {
        return view('auth.admin-login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'matricule' => ['required', 'string', 'alpha_dash'],
            'password' => ['required', 'string'],
        ]);
        $credentials['matricule'] = strtoupper(trim($credentials['matricule']));
        $credentials['role'] = 'admin';

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withInput($request->only('matricule'))->withErrors([
                'matricule' => 'Matricule ou mot de passe incorrect.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
