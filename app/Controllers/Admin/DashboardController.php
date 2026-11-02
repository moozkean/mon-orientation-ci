<?php

namespace App\Controllers\Admin;

use App\Models\City;
use App\Models\Domain;
use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\OrientationResult;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController
{
    /**
     * Display the Admin Analytics Dashboard.
     */
    public function index(): View
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalPrograms = Filiere::count();
        $totalInstitutions = Etablissement::count();
        $totalQuizzesCompleted = OrientationResult::count();

        $recentStudents = User::with(['bacSerie', 'city'])
            ->where('role', 'student')
            ->latest()
            ->take(6)
            ->get();

        $popularSeries = Serie::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(6)
            ->get();

        $featuredPrograms = Filiere::with(['domain', 'etablissements'])
            ->latest()
            ->take(5)
            ->get();

        $institutionsByType = [
            'universite_publique' => Etablissement::where('type', 'universite_publique')->count(),
            'grande_ecole_publique' => Etablissement::where('type', 'grande_ecole_publique')->count(),
            'universite_privee' => Etablissement::where('type', 'universite_privee')->count(),
            'grande_ecole_privee' => Etablissement::where('type', 'grande_ecole_privee')->count(),
            'centre_bts' => Etablissement::where('type', 'centre_bts')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalPrograms',
            'totalInstitutions',
            'totalQuizzesCompleted',
            'recentStudents',
            'popularSeries',
            'featuredPrograms',
            'institutionsByType'
        ));
    }
}
