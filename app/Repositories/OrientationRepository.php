<?php

namespace App\Repositories;

use App\Models\OrientationQuiz;
use App\Models\OrientationResult;
use Illuminate\Support\Collection;

class OrientationRepository
{
    /**
     * Get active quiz questions in order.
     */
    public function getActiveQuestions(): Collection
    {
        return OrientationQuiz::active()->get();
    }

    /**
     * Save an orientation result for a student.
     */
    public function saveResult(array $data): OrientationResult
    {
        return OrientationResult::create($data);
    }

    /**
     * Get orientation history for a user.
     */
    public function getUserHistory(int $userId): Collection
    {
        return OrientationResult::with('bacSerie')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Find a specific result by ID.
     */
    public function findResultById(int $id): ?OrientationResult
    {
        return OrientationResult::with('bacSerie')->find($id);
    }
}
