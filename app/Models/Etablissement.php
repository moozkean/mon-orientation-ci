<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Etablissement extends Model
{
    use HasFactory;

    protected $table = 'institutions';

    protected $fillable = [
        'name',
        'sigle',
        'type',
        'city_id',
        'address',
        'email',
        'phone',
        'website',
        'logo_url',
        'cover_image',
        'description',
        'is_accredited_mesrs',
        'is_accredited_cames',
        'latitude',
        'longitude',
        'established_year',
    ];

    protected $casts = [
        'is_accredited_mesrs' => 'boolean',
        'is_accredited_cames' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'established_year' => 'integer',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function filieres(): BelongsToMany
    {
        return $this->belongsToMany(Filiere::class, 'program_institution', 'institution_id', 'program_id')
            ->withPivot('tuition_fee_annual_fcfa', 'is_public_funded', 'is_accredited', 'seats_available')
            ->withTimestamps();
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable', 'favoritable_type', 'favoritable_id');
    }

    public function scopePublic($query)
    {
        return $query->whereIn('type', ['universite_publique', 'grande_ecole_publique']);
    }

    public function scopePrivate($query)
    {
        return $query->whereIn('type', ['universite_privee', 'grande_ecole_privee', 'centre_bts']);
    }

    public function scopeBts($query)
    {
        return $query->where('type', 'centre_bts');
    }
}
