<?php

namespace App\Controllers\Admin;

use App\Models\Serie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SerieAdminController
{
    public function index(): View
    {
        $series = Serie::withCount(['filieres', 'users'])->orderBy('code')->get();
        return view('admin.series.index', compact('series'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:bac_series,code',
            'name' => 'required|string|max:255',
            'stream' => 'required|string|max:100',
            'description' => 'nullable|string',
            'key_subjects' => 'nullable|string', // comma separated
        ]);

        if (!empty($validated['key_subjects'])) {
            $validated['key_subjects'] = array_map('trim', explode(',', $validated['key_subjects']));
        }

        Serie::create($validated);

        return redirect()->route('admin.series.index')->with('success', 'Série BAC ajoutée avec succès.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $serie = Serie::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:bac_series,code,' . $id,
            'name' => 'required|string|max:255',
            'stream' => 'required|string|max:100',
            'description' => 'nullable|string',
            'key_subjects' => 'nullable|string',
        ]);

        if (!empty($validated['key_subjects'])) {
            $validated['key_subjects'] = array_map('trim', explode(',', $validated['key_subjects']));
        }

        $serie->update($validated);

        return redirect()->route('admin.series.index')->with('success', 'Série BAC mise à jour avec succès.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $serie = Serie::findOrFail($id);
        $serie->delete();

        return redirect()->route('admin.series.index')->with('success', 'Série BAC supprimée.');
    }
}
