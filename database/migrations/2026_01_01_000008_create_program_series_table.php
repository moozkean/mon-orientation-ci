<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('bac_serie_id')->constrained('bac_series')->cascadeOnDelete();
            $table->enum('priority_level', [
                'Obligatoire',
                'Fortement Recommandé',
                'Recommandé',
                'Possible avec mise à niveau'
            ])->default('Recommandé');
            $table->decimal('min_recommended_grade', 4, 2)->default(10.00); // 10.00 / 20
            $table->json('key_subject_coefficients')->nullable(); // e.g. {"Mathématiques": 3, "Physique-Chimie": 2}
            $table->timestamps();

            $table->unique(['program_id', 'bac_serie_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_series');
    }
};
