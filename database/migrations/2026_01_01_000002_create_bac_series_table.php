<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bac_series', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // A1, A2, C, D, E, F1, F2, F3, F4, F5, F6, F7, G1, G2, G3
            $table->string('name');
            $table->string('stream'); // Enseignement Général, Enseignement Technique, Formation Professionnelle
            $table->text('description')->nullable();
            $table->json('key_subjects')->nullable(); // ["Mathématiques", "Sciences Physiques", ...]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bac_series');
    }
};
