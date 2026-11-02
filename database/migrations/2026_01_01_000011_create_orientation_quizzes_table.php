<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orientation_quizzes', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->string('category')->default('riasec'); // riasec, interest, aptitude, preference
            $table->string('dimension', 10)->nullable(); // R, I, A, S, E, C
            $table->json('options'); // [{"text": "...", "dimension": "R", "score": 3, "tags": [...]}, ...]
            $table->unsignedInteger('order_number')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orientation_quizzes');
    }
};
