<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultados_operativos_mensuales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete();
            $table->string('periodo', 7); // formato YYYY-MM
            $table->decimal('costo_total_acumulado', 14, 2);
            $table->decimal('avance_fisico', 6, 3)->nullable();
            $table->decimal('utilidad', 14, 2);
            $table->decimal('margen', 6, 3);
            $table->unique(['proyecto_id', 'periodo']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultados_operativos_mensuales');
    }
};
