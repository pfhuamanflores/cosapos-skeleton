<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete();
            $table->foreignId('resultado_operativo_mensual_id')->constrained('resultados_operativos_mensuales')->cascadeOnDelete();
            $table->string('periodo', 7);
            $table->dateTime('fecha_generacion');
            $table->enum('estado', ['Generado', 'Aprobado', 'Observado', 'Rechazado'])->default('Generado');
            $table->foreignId('generado_por')->constrained('usuarios')->restrictOnDelete();
            $table->foreignId('aprobado_por')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes_proyecto');
    }
};
