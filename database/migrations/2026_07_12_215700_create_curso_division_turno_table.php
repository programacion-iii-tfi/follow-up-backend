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
        Schema::create('curso_division_turno', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('curso');
            $table->char('division', 1);
            $table->string('turno');
            $table->unsignedInteger('capacidad_maxima')->default(30);
            $table->timestamps();

            $table->unique(['curso', 'division', 'turno']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_division_turno');
    }
};
