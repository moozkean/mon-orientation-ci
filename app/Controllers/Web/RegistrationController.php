<?php

namespace App\Controllers\Web;

use App\Models\City;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegistrationController
{
    public function create(): View
    {
        return view('auth.register', [
            'cities' => City::where('is_active', true)->orderBy('name')->get(),
            'series' => Serie::orderBy('code')->get(),
            'mentions' => ['Passable', 'Assez-Bien', 'Bien', 'Très-Bien'],
            'defaultYear' => (int) date('Y'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'bac_serie_id' => ['nullable', 'integer', 'exists:bac_series,id'],
            'bac_year' => ['nullable', 'integer', 'min:2000', 'max:2030'],
            'bac_mention' => ['nullable', 'in:Passable,Assez-Bien,Bien,Très-Bien'],
        ], [
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'bac_year' => $validated['bac_year'] ?? (int) date('Y'),
        ]);

        Auth::login($user);

        return redirect()->route('student.dashboard')->with('success', 'Votre compte étudiant est prêt.');
    }
}
