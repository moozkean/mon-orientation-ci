<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable()->unique();
            $table->string('password');
            $table->enum('role', ['student', 'admin', 'counselor'])->default('student');
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->foreignId('bac_serie_id')->nullable()->constrained('bac_series')->nullOnDelete();
            $table->year('bac_year')->nullable();
            $table->enum('bac_mention', ['Passable', 'Assez-Bien', 'Bien', 'Très-Bien'])->nullable();
            $table->json('academic_grades')->nullable(); // {"Mathématiques": 14, "Physique-Chimie": 15, "Français": 12, ...}
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
