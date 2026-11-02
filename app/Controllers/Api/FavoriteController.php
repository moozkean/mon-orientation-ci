<?php

namespace App\Controllers\Api;

use App\Models\Etablissement;
use App\Models\Favorite;
use App\Models\Filiere;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoriteController
{
    /**
     * Get all favorites of the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $favoritePrograms = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', 'program')
            ->pluck('favoritable_id');

        $favoriteInstitutions = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', 'institution')
            ->pluck('favoritable_id');

        $programs = Filiere::with(['domain', 'series', 'etablissements.city'])
            ->whereIn('id', $favoritePrograms)
            ->get();

        $institutions = Etablissement::with(['city', 'filieres'])
            ->whereIn('id', $favoriteInstitutions)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'programs' => $programs,
                'institutions' => $institutions,
                'total_favorites' => $programs->count() + $institutions->count(),
            ],
        ]);
    }

    /**
     * Toggle a favorite (add if not exists, delete if exists).
     */
    public function toggle(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:program,institution',
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Paramètres invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = $request->user();
        $type = $request->type;
        $id = (int) $request->id;

        $existing = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', $type)
            ->where('favoritable_id', $id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'is_favorite' => false,
                'message' => 'Retiré de vos favoris.',
            ]);
        }

        Favorite::create([
            'user_id' => $user->id,
            'favoritable_type' => $type,
            'favoritable_id' => $id,
        ]);

        return response()->json([
            'success' => true,
            'is_favorite' => true,
            'message' => 'Ajouté à vos favoris avec succès.',
        ]);
    }

    /**
     * Check if item is favorite.
     */
    public function check(Request $request): JsonResponse
    {
        $type = $request->query('type');
        $id = (int) $request->query('id');
        $user = $request->user();

        $isFavorite = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', $type)
            ->where('favoritable_id', $id)
            ->exists();

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite,
        ]);
    }
}
