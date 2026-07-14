<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tutor_alumno', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('alumno_id')->constrained('alumnos')->cascadeOnDelete();
            $table->foreignUuid('tutor_id')->constrained('tutores')->cascadeOnDelete();

            $table->string('relationship');
            $table->string('otra_relacion')->nullable();
            $table->string('codigo_institucional');

            $table->timestamps();

            $table->unique(['alumno_id', 'tutor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor_alumno');
    }
};
