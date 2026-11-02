<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Serie extends Model
{
    use HasFactory;

    protected $table = 'bac_series';

    protected $fillable = [
        'code',
        'name',
        'stream',
        'description',
        'key_subjects',
    ];

    protected $casts = [
        'key_subjects' => 'array',
    ];

    public function filieres(): BelongsToMany
    {
        return $this->belongsToMany(Filiere::class, 'program_series', 'bac_serie_id', 'program_id')
            ->withPivot('priority_level', 'min_recommended_grade', 'key_subject_coefficients')
            ->withTimestamps();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'bac_serie_id');
    }
}
