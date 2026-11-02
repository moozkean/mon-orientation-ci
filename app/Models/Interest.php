<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Interest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'icon',
    ];

    public function filieres(): BelongsToMany
    {
        return $this->belongsToMany(Filiere::class, 'program_interests', 'interest_id', 'program_id')
            ->withPivot('relevance_weight')
            ->withTimestamps();
    }
}
