<?php

namespace App\Repositories;

use App\Models\Filiere;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FiliereRepository
{
    /**
     * Search and filter filières with pagination.
     */
    public function search(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Filiere::with(['domain', 'series', 'etablissements.city']);

        // Search keyword
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Domain
        if (!empty($filters['domain_id'])) {
            $query->where('domain_id', $filters['domain_id']);
        }

        // Filter by Degree Level (BTS, Licence, Master, Ingenieur, Doctorat)
        if (!empty($filters['degree_level'])) {
            $query->where('degree_level', $filters['degree_level']);
        }

        // Filter by BAC Serie
        if (!empty($filters['bac_serie_id'])) {
            $query->whereHas('series', function (Builder $q) use ($filters) {
                $q->where('bac_series.id', $filters['bac_serie_id']);
            });
        }

        // Filter by City
        if (!empty($filters['city_id'])) {
            $query->whereHas('etablissements', function (Builder $q) use ($filters) {
                $q->where('institutions.city_id', $filters['city_id']);
            });
        }

        // Filter by Public vs Private
        if (isset($filters['is_public'])) {
            $isPublic = filter_var($filters['is_public'], FILTER_VALIDATE_BOOLEAN);
            $query->whereHas('etablissements', function (Builder $q) use ($isPublic) {
                if ($isPublic) {
                    $q->whereIn('type', ['universite_publique', 'grande_ecole_publique']);
                } else {
                    $q->whereIn('type', ['universite_privee', 'grande_ecole_privee', 'centre_bts']);
                }
            });
        }

        return $query->orderBy('is_featured', 'desc')->orderBy('name', 'asc')->paginate($perPage);
    }

    /**
     * Find filiere by ID or slug with relations.
     */
    public function findByIdOrSlug(string|int $idOrSlug): ?Filiere
    {
        return Filiere::with([
            'domain',
            'series',
            'interests',
            'etablissements.city',
        ])
        ->where('id', $idOrSlug)
        ->orWhere('slug', $idOrSlug)
        ->first();
    }

    /**
     * Compare 2 or 3 programs.
     */
    public function compare(array $programIds): Collection
    {
        return Filiere::with([
            'domain',
            'series',
            'interests',
            'etablissements.city',
        ])
        ->whereIn('id', $programIds)
        ->get();
    }

    /**
     * Get featured programs.
     */
    public function getFeatured(int $limit = 6): Collection
    {
        return Filiere::with(['domain', 'series', 'etablissements.city'])
            ->where('is_featured', true)
            ->take($limit)
            ->get();
    }
}
