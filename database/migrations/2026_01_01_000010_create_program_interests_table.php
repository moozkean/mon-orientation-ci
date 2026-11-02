<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('interest_id')->constrained('interests')->cascadeOnDelete();
            $table->unsignedTinyInteger('relevance_weight')->default(5); // 1-10
            $table->timestamps();

            $table->unique(['program_id', 'interest_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_interests');
    }
};
