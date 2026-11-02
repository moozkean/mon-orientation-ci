<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_institution', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('institution_id')->constrained('institutions')->cascadeOnDelete();
            $table->unsignedInteger('tuition_fee_annual_fcfa')->default(0); // 0 or 30000 FCFA for public, 400000+ for private
            $table->boolean('is_public_funded')->default(false);
            $table->boolean('is_accredited')->default(true);
            $table->unsignedInteger('seats_available')->nullable();
            $table->timestamps();

            $table->unique(['program_id', 'institution_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_institution');
    }
};
