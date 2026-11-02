<?php

namespace App\Controllers\Api;

use App\Models\City;
use App\Models\Domain;
use App\Models\Interest;
use App\Models\Serie;
use Illuminate\Http\JsonResponse;

class MetadataController
{
    /**
     * Get system metadata for app initialization and filter dropdowns.
     */
    public function getMetadata(): JsonResponse
    {
        $series = Serie::all();
        $cities = City::where('is_active', true)->orderBy('name')->get();
        $domains = Domain::withCount('filieres')->orderBy('name')->get();
        $interests = Interest::orderBy('category')->orderBy('name')->get();

        $degreeLevels = [
            ['code' => 'BTS', 'label' => 'Brevet de Technicien Supérieur (Bac+2)', 'duration' => 2],
            ['code' => 'Licence', 'label' => 'Licence / Bachelor (Bac+3)', 'duration' => 3],
            ['code' => 'Master', 'label' => 'Master Professionnel / Recherche (Bac+5)', 'duration' => 5],
            ['code' => 'Ingenieur', 'label' => 'Diplôme d\'Ingénieur d\'État (Bac+5)', 'duration' => 5],
            ['code' => 'Doctorat', 'label' => 'Doctorat / Diplôme d\'État Médecine (Bac+8)', 'duration' => 8],
        ];

        $institutionTypes = [
            ['code' => 'universite_publique', 'label' => 'Université Publique'],
            ['code' => 'grande_ecole_publique', 'label' => 'Grande École Publique (ex: INP-HB, ENS)'],
            ['code' => 'universite_privee', 'label' => 'Université Privée'],
            ['code' => 'grande_ecole_privee', 'label' => 'Grande École Privée'],
            ['code' => 'centre_bts', 'label' => 'Établissement préparant au BTS'],
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'series' => $series,
                'cities' => $cities,
                'domains' => $domains,
                'interests' => $interests,
                'degree_levels' => $degreeLevels,
                'institution_types' => $institutionTypes,
            ],
        ]);
    }
}
