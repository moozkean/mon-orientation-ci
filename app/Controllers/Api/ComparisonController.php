<?php

namespace App\Controllers\Api;

use App\Repositories\FiliereRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComparisonController
{
    protected FiliereRepository $filiereRepository;

    public function __construct(FiliereRepository $filiereRepository)
    {
        $this->filiereRepository = $filiereRepository;
    }

    /**
     * Compare up to 3 programs side by side.
     */
    public function compare(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'program_ids' => 'required|array|min:2|max:3',
            'program_ids.*' => 'integer|exists:programs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez sélectionner entre 2 et 3 filières valides à comparer.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $programs = $this->filiereRepository->compare($request->program_ids);

        // Format detailed side-by-side comparative matrix
        $comparison = $programs->map(function ($p) {
            $institutions = $p->etablissements->map(function ($inst) {
                return [
                    'id' => $inst->id,
                    'name' => $inst->name,
                    'sigle' => $inst->sigle,
                    'type' => $inst->type,
                    'city' => $inst->city->name ?? 'Abidjan',
                    'tuition_fee_annual_fcfa' => $inst->pivot->tuition_fee_annual_fcfa ?? 0,
                    'is_public_funded' => (bool) ($inst->pivot->is_public_funded ?? false),
                ];
            });

            $seriesEligible = $p->series->map(function ($s) {
                return [
                    'serie' => $s->code,
                    'name' => $s->name,
                    'priority' => $s->pivot->priority_level,
                    'min_grade' => $s->pivot->min_recommended_grade,
                ];
            });

            $minTuition = $institutions->min('tuition_fee_annual_fcfa') ?? 0;
            $maxTuition = $institutions->max('tuition_fee_annual_fcfa') ?? 0;

            return [
                'id' => $p->id,
                'name' => $p->name,
                'code' => $p->code,
                'domain' => $p->domain->name ?? 'Général',
                'degree_level' => $p->degree_level,
                'duration_years' => $p->duration_years,
                'difficulty_level' => $p->difficulty_level,
                'market_demand_rating' => $p->market_demand_rating,
                'average_starting_salary_fcfa' => $p->average_starting_salary_fcfa,
                'tuition_range' => [
                    'min_fcfa' => $minTuition,
                    'max_fcfa' => $maxTuition,
                    'has_public_option' => $institutions->contains('is_public_funded', true),
                ],
                'career_opportunities' => $p->career_opportunities ?? [],
                'admission_requirements' => $p->admission_requirements,
                'series_eligibility' => $seriesEligible,
                'institutions' => $institutions,
                'institutions_count' => $institutions->count(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'compared_programs' => $comparison,
                'comparison_criteria' => [
                    'Diplôme délivré',
                    'Durée d\'études (années)',
                    'Niveau d\'exigence / Difficulté',
                    'Frais de scolarité indicatifs',
                    'Demande sur le marché ivoirien',
                    'Débouchés professionnels',
                    'Séries BAC recommandées',
                    'Établissements habilités',
                ],
            ],
        ]);
    }
}
