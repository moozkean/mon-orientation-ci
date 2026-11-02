<?php

namespace App\Services;

use App\Models\Filiere;
use App\Models\Serie;
use App\Models\Interest;
use Illuminate\Support\Collection;

class MatchingService
{
    /**
     * Compute recommendations and compatibility scores for a student.
     *
     * @param int $bacSerieId
     * @param array $grades e.g. ["Mathématiques" => 14, "Physique-Chimie" => 15, "Français" => 12]
     * @param array $riasecScores e.g. ["R" => 60, "I" => 85, "A" => 40, "S" => 50, "E" => 70, "C" => 65]
     * @param array $selectedInterestIds array of interest IDs
     * @param int $limit
     * @return array
     */
    public function generateRecommendations(
        int $bacSerieId,
        array $grades = [],
        array $riasecScores = [],
        array $selectedInterestIds = [],
        int $limit = 10
    ): array {
        $serie = Serie::find($bacSerieId);
        if (!$serie) {
            return [];
        }

        // Fetch all active programs with relations
        $programs = Filiere::with([
            'domain',
            'series' => function ($query) use ($bacSerieId) {
                $query->where('bac_series.id', $bacSerieId);
            },
            'interests',
            'etablissements.city',
        ])->get();

        $scoredPrograms = [];

        foreach ($programs as $program) {
            $seriePivot = $program->series->first()?->pivot;

            // 1. Serie Compatibility Score (0 - 100)
            $serieScore = $this->calculateSerieScore($seriePivot);

            // If completely incompatible with the series, skip or assign low base
            if ($serieScore <= 0) {
                continue;
            }

            // 2. Academic Grades Score (0 - 100)
            $gradeScore = $this->calculateGradeScore($program, $seriePivot, $grades);

            // 3. Interests & RIASEC Personality Score (0 - 100)
            $interestScore = $this->calculateInterestAndRiasecScore(
                $program,
                $riasecScores,
                $selectedInterestIds
            );

            // 4. Market Demand & National Priority Bonus (0 - 100)
            $marketScore = min(100, ($program->market_demand_rating / 5.0) * 100);

            // Weighted Total Compatibility Score:
            // - BAC Series match: 35%
            // - Academic Grades alignment: 30%
            // - Interests & Personality alignment: 25%
            // - Market demand in Côte d'Ivoire: 10%
            $finalScore = round(
                ($serieScore * 0.35) +
                ($gradeScore * 0.30) +
                ($interestScore * 0.25) +
                ($marketScore * 0.10)
            );

            $finalScore = max(10, min(99, (int) $finalScore));

            // Generate qualitative evaluation and advice
            $evaluation = $this->buildEvaluation($finalScore, $serieScore, $gradeScore, $interestScore, $program);

            $scoredPrograms[] = [
                'program_id' => $program->id,
                'program_name' => $program->name,
                'program_code' => $program->code,
                'degree_level' => $program->degree_level,
                'duration_years' => $program->duration_years,
                'domain_name' => $program->domain->name ?? 'Général',
                'compatibility_score' => $finalScore,
                'score_breakdown' => [
                    'serie_alignment' => (int) $serieScore,
                    'academic_grades' => (int) $gradeScore,
                    'interests_profile' => (int) $interestScore,
                    'market_demand' => (int) $marketScore,
                ],
                'evaluation' => $evaluation,
                'career_opportunities' => $program->career_opportunities ?? [],
                'priority_level' => $seriePivot ? $seriePivot->priority_level : 'Non spécifié',
                'institutions' => $program->etablissements->map(function ($inst) {
                    return [
                        'id' => $inst->id,
                        'name' => $inst->name,
                        'sigle' => $inst->sigle,
                        'type' => $inst->type,
                        'city' => $inst->city->name ?? 'Abidjan',
                        'tuition_fee_annual_fcfa' => $inst->pivot->tuition_fee_annual_fcfa ?? 0,
                        'is_public_funded' => (bool) ($inst->pivot->is_public_funded ?? false),
                    ];
                })->take(4)->values()->toArray(),
            ];
        }

        // Sort descending by compatibility score
        usort($scoredPrograms, fn($a, $b) => $b['compatibility_score'] <=> $a['compatibility_score']);

        return array_slice($scoredPrograms, 0, $limit);
    }

    private function calculateSerieScore($seriePivot): float
    {
        if (!$seriePivot) {
            return 25.0; // Allowed with strong leveling up
        }

        return match ($seriePivot->priority_level) {
            'Obligatoire' => 100.0,
            'Fortement Recommandé' => 95.0,
            'Recommandé' => 80.0,
            'Possible avec mise à niveau' => 50.0,
            default => 40.0,
        };
    }

    private function calculateGradeScore(Filiere $program, $seriePivot, array $grades): float
    {
        if (empty($grades)) {
            return 70.0; // Default average score if grades are not supplied
        }

        $minRecommended = $seriePivot ? (float) $seriePivot->min_recommended_grade : 10.0;
        $coefficients = $seriePivot && $seriePivot->key_subject_coefficients
            ? (is_array($seriePivot->key_subject_coefficients)
                ? $seriePivot->key_subject_coefficients
                : json_decode($seriePivot->key_subject_coefficients, true))
            : [];

        if (empty($coefficients)) {
            // Calculate simple average of submitted grades
            $validGrades = array_filter($grades, fn($g) => is_numeric($g) && $g >= 0 && $g <= 20);
            if (empty($validGrades)) {
                return 70.0;
            }
            $avg = array_sum($validGrades) / count($validGrades);
            return min(100.0, max(20.0, ($avg / 20.0) * 100.0));
        }

        $totalWeightedPoints = 0;
        $totalCoeffs = 0;

        foreach ($coefficients as $subject => $coeff) {
            $grade = isset($grades[$subject]) ? (float) $grades[$subject] : 10.0; // Fallback to 10/20
            $totalWeightedPoints += $grade * $coeff;
            $totalCoeffs += $coeff;
        }

        $weightedAverage = $totalCoeffs > 0 ? $totalWeightedPoints / $totalCoeffs : 10.0;

        // Ratio compared to minimum requirement
        if ($weightedAverage >= 16) {
            return 98.0;
        } elseif ($weightedAverage >= 14) {
            return 90.0;
        } elseif ($weightedAverage >= 12) {
            return 80.0;
        } elseif ($weightedAverage >= 10) {
            return 65.0;
        } else {
            return max(20.0, ($weightedAverage / 10.0) * 50.0);
        }
    }

    private function calculateInterestAndRiasecScore(
        Filiere $program,
        array $riasecScores,
        array $selectedInterestIds
    ): float {
        $score = 60.0; // Base score

        // Check matching with program interests
        if (!empty($selectedInterestIds)) {
            $programInterestIds = $program->interests->pluck('id')->toArray();
            $matches = array_intersect($selectedInterestIds, $programInterestIds);
            if (count($programInterestIds) > 0) {
                $interestOverlap = (count($matches) / count($programInterestIds)) * 40.0;
                $score += $interestOverlap;
            }
        }

        // RIASEC Profile matching
        if (!empty($riasecScores)) {
            $domainSlug = $program->domain->slug ?? '';
            $dominantDimension = match (true) {
                str_contains($domainSlug, 'techno') || str_contains($domainSlug, 'info') || str_contains($domainSlug, 'ingenieur') => 'I', // Investigateur
                str_contains($domainSlug, 'mecanique') || str_contains($domainSlug, 'btp') || str_contains($domainSlug, 'agro') => 'R', // Réaliste
                str_contains($domainSlug, 'art') || str_contains($domainSlug, 'comm') || str_contains($domainSlug, 'lettre') => 'A', // Artistique
                str_contains($domainSlug, 'sante') || str_contains($domainSlug, 'social') || str_contains($domainSlug, 'educ') => 'S', // Social
                str_contains($domainSlug, 'gestion') || str_contains($domainSlug, 'commerce') || str_contains($domainSlug, 'droit') => 'E', // Entreprenant
                default => 'C', // Conventionnel
            };

            $dimScore = $riasecScores[$dominantDimension] ?? 60;
            $score = ($score * 0.6) + ($dimScore * 0.4);
        }

        return min(100.0, max(20.0, $score));
    }

    private function buildEvaluation(
        int $finalScore,
        float $serieScore,
        float $gradeScore,
        float $interestScore,
        Filiere $program
    ): array {
        if ($finalScore >= 85) {
            $level = 'Compatibilité Excellente';
            $verdict = 'Votre profil académique et vos centres d’intérêt correspondent parfaitement aux exigences de cette formation en Côte d’Ivoire.';
        } elseif ($finalScore >= 70) {
            $level = 'Forte Compatibilité';
            $verdict = 'Très bonne orientation. Vous avez les prérequis nécessaires pour réussir dans cette filière.';
        } elseif ($finalScore >= 55) {
            $level = 'Compatibilité Modérée';
            $verdict = 'Filière accessible avec un travail soutenu dans les matières scientifiques ou techniques de base.';
        } else {
            $level = 'Mise à niveau conseillée';
            $verdict = 'Cette formation nécessite une mise à niveau préalable ou un accompagnement renforcé.';
        }

        return [
            'level' => $level,
            'verdict' => $verdict,
            'highlights' => [
                'Série BAC adaptée aux exigences du MESRS',
                'Perspectives d’insertion professionnelle dynamiques en CI',
                'Formations habilitées par le CAMES et le Ministère',
            ],
            'prerequisites_summary' => $program->admission_requirements ?? 'BAC obtenu ou équivalent reconnu par le MESRS.',
        ];
    }
}
