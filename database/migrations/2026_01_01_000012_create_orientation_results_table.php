<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orientation_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('bac_serie_id')->constrained('bac_series')->cascadeOnDelete();
            $table->json('grades_input')->nullable(); // Subject grades provided by student
            $table->json('quiz_answers')->nullable(); // User's selected quiz answers
            $table->json('riasec_scores')->nullable(); // Calculated RIASEC profile (R, I, A, S, E, C percentages)
            $table->json('selected_interest_ids')->nullable();
            $table->json('recommendations'); // Ranked recommendations with compatibility score & analysis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orientation_results');
    }
};
