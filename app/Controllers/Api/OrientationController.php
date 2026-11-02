<?php

namespace App\Controllers\Api;

use App\Models\OrientationQuiz;
use App\Models\OrientationResult;
use App\Models\Serie;
use App\Repositories\OrientationRepository;
use App\Services\MatchingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrientationController
{
    protected OrientationRepository $orientationRepository;
    protected MatchingService $matchingService;

    public function __construct(
        OrientationRepository $orientationRepository,
        MatchingService $matchingService
    ) {
        $this->orientationRepository = $orientationRepository;
        $this->matchingService = $matchingService;
    }

    /**
     * Get active orientation quiz questions.
     */
    public function getQuestions(): JsonResponse
    {
        $questions = $this->orientationRepository->getActiveQuestions();

        return response()->json([
            'success' => true,
            'data' => $questions,
        ]);
    }

    /**
     * Submit questionnaire, calculate compatibility, and return recommendations.
     */
    public function submitQuiz(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'bac_serie_id' => 'required|exists:bac_series,id',
            'grades' => 'nullable|array', // e.g. {"Mathématiques": 14, "Physique-Chimie": 13, "Français": 12}
            'quiz_answers' => 'nullable|array', // array of question_id => option_dimension
            'riasec_scores' => 'nullable|array', // {"R": 60, "I": 85, "A": 45, "S": 55, "E": 75, "C": 70}
            'selected_interest_ids' => 'nullable|array',
            'selected_interest_ids.*' => 'exists:interests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données du questionnaire incomplètes ou invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $bacSerieId = (int) $request->bac_serie_id;
        $grades = $request->grades ?? [];
        $quizAnswers = $request->quiz_answers ?? [];
        $riasecScores = $request->riasec_scores ?? [];
        $selectedInterestIds = $request->selected_interest_ids ?? [];

        // If riasecScores not explicitly computed by frontend, compute from quiz answers
        if (empty($riasecScores) && !empty($quizAnswers)) {
            $riasecScores = $this->computeRiasecFromAnswers($quizAnswers);
        }

        // Run matching recommendation engine
        $recommendations = $this->matchingService->generateRecommendations(
            $bacSerieId,
            $grades,
            $riasecScores,
            $selectedInterestIds,
            12
        );

        $user = $request->user();
        $userId = $user ? $user->id : null;

        // Persist the result in database
        $savedResult = $this->orientationRepository->saveResult([
            'user_id' => $userId,
            'bac_serie_id' => $bacSerieId,
            'grades_input' => $grades,
            'quiz_answers' => $quizAnswers,
            'riasec_scores' => $riasecScores,
            'selected_interest_ids' => $selectedInterestIds,
            'recommendations' => $recommendations,
        ]);

        $serie = Serie::find($bacSerieId);

        return response()->json([
            'success' => true,
            'message' => 'Analyse d\'orientation terminée avec succès.',
            'data' => [
                'result_id' => $savedResult->id,
                'bac_serie' => [
                    'id' => $serie->id,
                    'code' => $serie->code,
                    'name' => $serie->name,
                ],
                'riasec_scores' => $riasecScores,
                'recommendations' => $recommendations,
                'total_recommendations' => count($recommendations),
                'top_match' => $recommendations[0] ?? null,
            ],
        ]);
    }

    /**
     * Get orientation history for authenticated user.
     */
    public function getHistory(Request $request): JsonResponse
    {
        $user = $request->user();
        $history = $this->orientationRepository->getUserHistory($user->id);

        return response()->json([
            'success' => true,
            'data' => $history,
        ]);
    }

    /**
     * Get a specific orientation result by ID.
     */
    public function getResult(int $id): JsonResponse
    {
        $result = $this->orientationRepository->findResultById($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Résultat d\'orientation introuvable.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    private function computeRiasecFromAnswers(array $answers): array
    {
        $totals = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
        $counts = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];

        foreach ($answers as $questionId => $optionDimension) {
            $dim = strtoupper((string) $optionDimension);
            if (isset($totals[$dim])) {
                $totals[$dim] += 10;
                $counts[$dim] += 1;
            }
        }

        $scores = [];
        foreach ($totals as $dim => $val) {
            // Normalize to 30-95%
            $scores[$dim] = min(95, max(30, 40 + ($val * 8)));
        }

        return $scores;
    }
}
