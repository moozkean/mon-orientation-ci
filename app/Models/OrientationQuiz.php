<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrientationQuiz extends Model
{
    use HasFactory;

    protected $table = 'orientation_quizzes';

    protected $fillable = [
        'question_text',
        'category',
        'dimension',
        'options',
        'order_number',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'order_number' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order_number');
    }
}
