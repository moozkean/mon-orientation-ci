<?php

namespace App\Controllers\Admin;

use App\Models\City;
use App\Models\Etablissement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtablissementAdminController
{
    public function index(Request $request): View
    {
        $query = Etablissement::with(['city', 'filieres']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('sigle', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        $etablissements = $query->latest()->paginate(12);
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('admin.etablissements.index', compact('etablissements', 'cities'));
    }

    public function create(): View
    {
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('admin.etablissements.form', [
            'etablissement' => new Etablissement(),
            'cities' => $cities,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sigle' => 'nullable|string|max:20',
            'type' => 'required|in:universite_publique,grande_ecole_publique,universite_privee,grande_ecole_privee,centre_bts',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'logo_url' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'description' => 'nullable|string',
            'is_accredited_mesrs' => 'boolean',
            'is_accredited_cames' => 'boolean',
            'established_year' => 'nullable|integer|min:1950|max:2030',
        ]);

        $validated['is_accredited_mesrs'] = $request->has('is_accredited_mesrs');
        $validated['is_accredited_cames'] = $request->has('is_accredited_cames');

        Etablissement::create($validated);

        return redirect()->route('admin.etablissements.index')->with('success', 'Établissement ajouté avec succès.');
    }

    public function edit(int $id): View
    {
        $etablissement = Etablissement::findOrFail($id);
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('admin.etablissements.form', [
            'etablissement' => $etablissement,
            'cities' => $cities,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $etablissement = Etablissement::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sigle' => 'nullable|string|max:20',
            'type' => 'required|in:universite_publique,grande_ecole_publique,universite_privee,grande_ecole_privee,centre_bts',
            'city_id' => 'required|exists:cities,id',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|url|max:255',
            'logo_url' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'description' => 'nullable|string',
            'established_year' => 'nullable|integer|min:1950|max:2030',
        ]);

        $validated['is_accredited_mesrs'] = $request->has('is_accredited_mesrs');
        $validated['is_accredited_cames'] = $request->has('is_accredited_cames');

        $etablissement->update($validated);

        return redirect()->route('admin.etablissements.index')->with('success', 'Établissement mis à jour avec succès.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $etablissement = Etablissement::findOrFail($id);
        $etablissement->delete();

        return redirect()->route('admin.etablissements.index')->with('success', 'Établissement supprimé avec succès.');
    }
}
