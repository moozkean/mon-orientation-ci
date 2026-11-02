<?php

namespace App\Controllers\Web;

use App\Models\Etablissement;
use App\Models\Filiere;
use App\Models\Interest;
use App\Models\OrientationQuiz;
use App\Models\OrientationResult;
use App\Models\Serie;
use App\Repositories\OrientationRepository;
use App\Services\MatchingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController
{
    public function __construct(
        private readonly MatchingService $matching,
        private readonly OrientationRepository $repository,
    ) {}

    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $results = OrientationResult::where('user_id', $user->id)->latest()->take(3)->get();

        return view('student.dashboard', [
            'user' => $user->load(['city', 'bacSerie']),
            'results' => $results,
            'featuredPrograms' => Filiere::with(['domain', 'etablissements'])->featured()->take(6)->get(),
            'programCount' => Filiere::count(),
            'institutionCount' => Etablissement::count(),
            'resultCount' => $results->count(),
        ]);
    }

    public function programs(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'degree' => ['nullable', 'in:BTS,Licence,Master,Ingenieur,Doctorat'],
            'domain' => ['nullable', 'integer', 'exists:domains,id'],
        ]);

        $programs = Filiere::with(['domain', 'etablissements'])
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where(fn ($query) => $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")))
            ->when($filters['degree'] ?? null, fn ($query, $degree) => $query->where('degree_level', $degree))
            ->when($filters['domain'] ?? null, fn ($query, $domain) => $query->where('domain_id', $domain))
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        return view('student.programs', [
            'programs' => $programs,
            'domains' => \App\Models\Domain::orderBy('name')->get(),
            'degrees' => ['BTS', 'Licence', 'Master', 'Ingenieur', 'Doctorat'],
            'filters' => $filters,
        ]);
    }

    public function program(Filiere $filiere): View
    {
        return view('student.program', [
            'program' => $filiere->load(['domain', 'series', 'interests', 'etablissements.city']),
        ]);
    }

    public function institutions(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'integer', 'exists:cities,id'],
            'type' => ['nullable', 'string'],
        ]);

        $institutions = Etablissement::with(['city', 'filieres'])
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where(fn ($query) => $query->where('name', 'like', "%{$search}%")
                ->orWhere('sigle', 'like', "%{$search}%")))
            ->when($filters['city'] ?? null, fn ($query, $city) => $query->where('city_id', $city))
            ->when($filters['type'] ?? null, fn ($query, $type) => $query->where('type', $type))
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        return view('student.institutions', [
            'institutions' => $institutions,
            'cities' => \App\Models\City::where('is_active', true)->orderBy('name')->get(),
            'types' => ['universite_publique', 'grande_ecole_publique', 'universite_privee', 'grande_ecole_privee', 'centre_bts'],
            'filters' => $filters,
        ]);
    }

    public function institution(Etablissement $institution): View
    {
        return view('student.institution', [
            'institution' => $institution->load(['city', 'filieres.domain']),
        ]);
    }

    public function orientation(): View
    {
        return view('student.orientation', [
            'questions' => OrientationQuiz::active()->get(),
            'interests' => Interest::orderBy('name')->get(),
            'series' => Serie::orderBy('code')->get(),
        ]);
    }

    public function submitOrientation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bac_serie_id' => ['required', 'integer', 'exists:bac_series,id'],
            'grades' => ['nullable', 'array'],
            'grades.*' => ['nullable', 'numeric', 'between:0,20'],
            'answers' => ['required', 'array', 'size:' . OrientationQuiz::active()->count()],
            'selected_interest_ids' => ['nullable', 'array'],
            'selected_interest_ids.*' => ['integer', 'exists:interests,id'],
        ]);

        $riasec = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
        foreach ($validated['answers'] as $dimension) {
            $dimension = strtoupper((string) $dimension);
            if (isset($riasec[$dimension])) {
                $riasec[$dimension]++;
            }
        }

        $totalAnswers = max(1, count($validated['answers']));
        $riasec = array_map(fn ($score) => min(95, 25 + (int) round(($score / $totalAnswers) * 100)), $riasec);
        $recommendations = $this->matching->generateRecommendations(
            (int) $validated['bac_serie_id'],
            $validated['grades'] ?? [],
            $riasec,
            $validated['selected_interest_ids'] ?? [],
            12,
        );

        $result = $this->repository->saveResult([
            'user_id' => $request->user()->id,
            'bac_serie_id' => $validated['bac_serie_id'],
            'grades_input' => $validated['grades'] ?? [],
            'quiz_answers' => $validated['answers'],
            'riasec_scores' => $riasec,
            'selected_interest_ids' => $validated['selected_interest_ids'] ?? [],
            'recommendations' => $recommendations,
        ]);

        return redirect()->route('student.results.show', $result);
    }

    public function results(Request $request): View
    {
        return view('student.results', [
            'results' => OrientationResult::where('user_id', $request->user()->id)->latest()->paginate(10),
        ]);
    }

    public function result(Request $request, OrientationResult $result): View
    {
        abort_unless($result->user_id === $request->user()->id, 403);

        return view('student.result', [
            'result' => $result->load('bacSerie'),
        ]);
    }
}
