<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sigle', 20)->nullable(); // UFHB, INP-HB, UNA, UAO, UJLoG, UPGC, USP, etc.
            $table->enum('type', [
                'universite_publique',
                'grande_ecole_publique',
                'universite_privee',
                'grande_ecole_privee',
                'centre_bts'
            ]);
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('website')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_accredited_mesrs')->default(true); // Ministère de l'Enseignement Supérieur CI
            $table->boolean('is_accredited_cames')->default(true); // CAMES
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->year('established_year')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};
