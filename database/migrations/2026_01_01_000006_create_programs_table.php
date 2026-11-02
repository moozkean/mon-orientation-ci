<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 30)->unique(); // e.g., LIC-INFO-01, BTS-IDA, ING-TP
            $table->string('slug', 191)->unique();
            $table->foreignId('domain_id')->constrained('domains')->cascadeOnDelete();
            $table->enum('degree_level', ['BTS', 'Licence', 'Master', 'Ingenieur', 'Doctorat']);
            $table->unsignedTinyInteger('duration_years')->default(3);
            $table->text('description');
            $table->text('admission_requirements')->nullable();
            $table->json('career_opportunities')->nullable(); // ["Développeur Fullstack", "Architecte Cloud", "Data Analyst"]
            $table->enum('difficulty_level', ['Facile', 'Modéré', 'Exigeant', 'Très Exigeant'])->default('Modéré');
            $table->unsignedTinyInteger('market_demand_rating')->default(4); // 1-5
            $table->unsignedInteger('average_starting_salary_fcfa')->nullable(); // Indicatif marché ivoirien
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
