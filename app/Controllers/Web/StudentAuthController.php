<?php

namespace App\Controllers\Web;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentAuthController
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $field = str_contains($credentials['login'], '@') ? 'email' : 'phone';
        if (Auth::attempt([$field => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'student') {
                Auth::logout();
                return back()->withErrors(['login' => 'Cette page est réservée aux étudiants.']);
            }

            return redirect()->intended(route('student.dashboard'));
        }

        return back()->withInput($request->only('login'))->withErrors([
            'login' => 'E-mail/téléphone ou mot de passe incorrect.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
