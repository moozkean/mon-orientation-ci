<?php

namespace App\Repositories;

use App\Models\Etablissement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EtablissementRepository
{
    /**
     * Search and filter institutions with pagination.
     */
    public function search(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Etablissement::with(['city', 'filieres.domain']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sigle', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['city_id'])) {
            $query->where('city_id', $filters['city_id']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['is_public'])) {
            $isPublic = filter_var($filters['is_public'], FILTER_VALIDATE_BOOLEAN);
            if ($isPublic) {
                $query->whereIn('type', ['universite_publique', 'grande_ecole_publique']);
            } else {
                $query->whereIn('type', ['universite_privee', 'grande_ecole_privee', 'centre_bts']);
            }
        }

        if (isset($filters['accredited_cames'])) {
            $query->where('is_accredited_cames', true);
        }

        return $query->orderBy('name', 'asc')->paginate($perPage);
    }

    /**
     * Find institution by ID with full relations.
     */
    public function findById(int $id): ?Etablissement
    {
        return Etablissement::with([
            'city',
            'filieres.domain',
            'filieres.series',
        ])->find($id);
    }

    /**
     * Get top public universities in Côte d'Ivoire.
     */
    public function getTopPublicUniversities(): Collection
    {
        return Etablissement::with('city')
            ->whereIn('type', ['universite_publique', 'grande_ecole_publique'])
            ->orderBy('name')
            ->get();
    }
}
