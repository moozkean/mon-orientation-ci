<?php

namespace App\Controllers\Admin;

use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DomainAdminController
{
    public function index(): View
    {
        $domains = Domain::withCount('filieres')->orderBy('name')->get();
        return view('admin.domains.index', compact('domains'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color_code' => 'nullable|string|max:20',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        Domain::create($validated);

        return redirect()->route('admin.domains.index')->with('success', 'Domaine d\'études ajouté avec succès.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $domain = Domain::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color_code' => 'nullable|string|max:20',
        ]);

        $domain->update($validated);

        return redirect()->route('admin.domains.index')->with('success', 'Domaine mis à jour avec succès.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $domain = Domain::findOrFail($id);
        $domain->delete();

        return redirect()->route('admin.domains.index')->with('success', 'Domaine supprimé.');
    }
}
