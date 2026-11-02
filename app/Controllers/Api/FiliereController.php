<?php

namespace App\Controllers\Api;

use App\Repositories\FiliereRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FiliereController
{
    protected FiliereRepository $filiereRepository;

    public function __construct(FiliereRepository $filiereRepository)
    {
        $this->filiereRepository = $filiereRepository;
    }

    /**
     * Get paginated list of programs with filters.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->query('search'),
            'domain_id' => $request->query('domain_id'),
            'degree_level' => $request->query('degree_level'),
            'bac_serie_id' => $request->query('bac_serie_id'),
            'city_id' => $request->query('city_id'),
            'is_public' => $request->query('is_public'),
        ];

        $perPage = (int) $request->query('per_page', 15);
        $programs = $this->filiereRepository->search($filters, $perPage);

        return response()->json([
            'success' => true,
            'data' => $programs->items(),
            'meta' => [
                'current_page' => $programs->currentPage(),
                'last_page' => $programs->lastPage(),
                'per_page' => $programs->perPage(),
                'total' => $programs->total(),
            ],
        ]);
    }

    /**
     * Get single program detail by ID or slug.
     */
    public function show(string|int $idOrSlug): JsonResponse
    {
        $program = $this->filiereRepository->findByIdOrSlug($idOrSlug);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Filière introuvable.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $program,
        ]);
    }

    /**
     * Get featured / popular programs in Côte d'Ivoire.
     */
    public function featured(): JsonResponse
    {
        $featured = $this->filiereRepository->getFeatured(8);

        return response()->json([
            'success' => true,
            'data' => $featured,
        ]);
    }
}
