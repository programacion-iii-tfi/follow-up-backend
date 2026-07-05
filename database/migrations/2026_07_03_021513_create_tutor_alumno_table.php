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
            $table->foreignUuid('tutor_id')->constrained('tutores')->cascadeOnDelete();
            $table->foreignUuid('alumno_id')->constrained('alumnos')->cascadeOnDelete();
            $table->primary(['tutor_id', 'alumno_id']);
            $table->timestamps();
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
