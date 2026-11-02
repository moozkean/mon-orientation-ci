<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Filiere extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'name',
        'code',
        'slug',
        'domain_id',
        'degree_level',
        'duration_years',
        'description',
        'admission_requirements',
        'career_opportunities',
        'difficulty_level',
        'market_demand_rating',
        'average_starting_salary_fcfa',
        'is_featured',
    ];

    protected $casts = [
        'duration_years' => 'integer',
        'career_opportunities' => 'array',
        'market_demand_rating' => 'integer',
        'average_starting_salary_fcfa' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }

    public function etablissements(): BelongsToMany
    {
        return $this->belongsToMany(Etablissement::class, 'program_institution', 'program_id', 'institution_id')
            ->withPivot('tuition_fee_annual_fcfa', 'is_public_funded', 'is_accredited', 'seats_available')
            ->withTimestamps();
    }

    public function series(): BelongsToMany
    {
        return $this->belongsToMany(Serie::class, 'program_series', 'program_id', 'bac_serie_id')
            ->withPivot('priority_level', 'min_recommended_grade', 'key_subject_coefficients')
            ->withTimestamps();
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'program_interests', 'program_id', 'interest_id')
            ->withPivot('relevance_weight')
            ->withTimestamps();
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable', 'favoritable_type', 'favoritable_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByDegree($query, string $level)
    {
        return $query->where('degree_level', $level);
    }
}
