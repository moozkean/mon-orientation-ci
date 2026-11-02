<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrientationResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bac_serie_id',
        'grades_input',
        'quiz_answers',
        'riasec_scores',
        'selected_interest_ids',
        'recommendations',
    ];

    protected $casts = [
        'grades_input' => 'array',
        'quiz_answers' => 'array',
        'riasec_scores' => 'array',
        'selected_interest_ids' => 'array',
        'recommendations' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bacSerie(): BelongsTo
    {
        return $this->belongsTo(Serie::class, 'bac_serie_id');
    }
}
