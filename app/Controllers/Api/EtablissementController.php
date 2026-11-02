<?php

namespace App\Controllers\Api;

use App\Repositories\EtablissementRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EtablissementController
{
    protected EtablissementRepository $etablissementRepository;

    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }

    /**
     * Get paginated institutions list with filters.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'search' => $request->query('search'),
            'city_id' => $request->query('city_id'),
            'type' => $request->query('type'),
            'is_public' => $request->query('is_public'),
            'accredited_cames' => $request->query('accredited_cames'),
        ];

        $perPage = (int) $request->query('per_page', 15);
        $institutions = $this->etablissementRepository->search($filters, $perPage);

        return response()->json([
            'success' => true,
            'data' => $institutions->items(),
            'meta' => [
                'current_page' => $institutions->currentPage(),
                'last_page' => $institutions->lastPage(),
                'per_page' => $institutions->perPage(),
                'total' => $institutions->total(),
            ],
        ]);
    }

    /**
     * Get single institution detail.
     */
    public function show(int $id): JsonResponse
    {
        $institution = $this->etablissementRepository->findById($id);

        if (!$institution) {
            return response()->json([
                'success' => false,
                'message' => 'Établissement introuvable.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $institution,
        ]);
    }

    /**
     * Get top public universities in Côte d'Ivoire.
     */
    public function topUniversities(): JsonResponse
    {
        $universities = $this->etablissementRepository->getTopPublicUniversities();

        return response()->json([
            'success' => true,
            'data' => $universities,
        ]);
    }
}
