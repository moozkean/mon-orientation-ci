<?php

namespace App\Controllers\Admin;

use App\Models\Domain;
use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Serie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FiliereAdminController
{
    public function index(Request $request): View
    {
        $query = Filiere::with(['domain', 'series', 'etablissements']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
        }

        if ($request->filled('domain_id')) {
            $query->where('domain_id', $request->domain_id);
        }

        $filieres = $query->latest()->paginate(12);
        $domains = Domain::all();

        return view('admin.filieres.index', compact('filieres', 'domains'));
    }

    public function create(): View
    {
        $domains = Domain::all();
        $series = Serie::all();
        $institutions = Etablissement::all();

        return view('admin.filieres.form', [
            'filiere' => new Filiere(),
            'domains' => $domains,
            'series' => $series,
            'institutions' => $institutions,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:30|unique:programs,code',
            'domain_id' => 'required|exists:domains,id',
            'degree_level' => 'required|in:BTS,Licence,Master,Ingenieur,Doctorat',
            'duration_years' => 'required|integer|min:1|max:10',
            'description' => 'required|string',
            'admission_requirements' => 'nullable|string',
            'career_opportunities' => 'nullable|string', // comma separated in form
            'difficulty_level' => 'required|in:Facile,Modéré,Exigeant,Très Exigeant',
            'market_demand_rating' => 'required|integer|min:1|max:5',
            'average_starting_salary_fcfa' => 'nullable|integer',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . strtolower($validated['code']);
        if (!empty($validated['career_opportunities'])) {
            $validated['career_opportunities'] = array_map('trim', explode(',', $validated['career_opportunities']));
        }

        $filiere = Filiere::create($validated);

        if ($request->has('series')) {
            $filiere->series()->sync($request->series);
        }

        if ($request->has('institutions')) {
            $filiere->etablissements()->sync($request->institutions);
        }

        return redirect()->route('admin.filieres.index')->with('success', 'Filière ajoutée avec succès.');
    }

    public function edit(int $id): View
    {
        $filiere = Filiere::with(['series', 'etablissements'])->findOrFail($id);
        $domains = Domain::all();
        $series = Serie::all();
        $institutions = Etablissement::all();

        return view('admin.filieres.form', [
            'filiere' => $filiere,
            'domains' => $domains,
            'series' => $series,
            'institutions' => $institutions,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $filiere = Filiere::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:30|unique:programs,code,' . $id,
            'domain_id' => 'required|exists:domains,id',
            'degree_level' => 'required|in:BTS,Licence,Master,Ingenieur,Doctorat',
            'duration_years' => 'required|integer|min:1|max:10',
            'description' => 'required|string',
            'admission_requirements' => 'nullable|string',
            'career_opportunities' => 'nullable|string',
            'difficulty_level' => 'required|in:Facile,Modéré,Exigeant,Très Exigeant',
            'market_demand_rating' => 'required|integer|min:1|max:5',
            'average_starting_salary_fcfa' => 'nullable|integer',
            'is_featured' => 'boolean',
        ]);

        if (!empty($validated['career_opportunities'])) {
            $validated['career_opportunities'] = array_map('trim', explode(',', $validated['career_opportunities']));
        }

        $filiere->update($validated);

        if ($request->has('series')) {
            $filiere->series()->sync($request->series);
        }

        if ($request->has('institutions')) {
            $filiere->etablissements()->sync($request->institutions);
        }

        return redirect()->route('admin.filieres.index')->with('success', 'Filière mise à jour avec succès.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $filiere = Filiere::findOrFail($id);
        $filiere->delete();

        return redirect()->route('admin.filieres.index')->with('success', 'Filière supprimée avec succès.');
    }
}
