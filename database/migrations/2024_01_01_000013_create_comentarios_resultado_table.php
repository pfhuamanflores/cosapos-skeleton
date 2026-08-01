<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios_resultado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resultado_operativo_mensual_id')->constrained('resultados_operativos_mensuales')->cascadeOnDelete();
            $table->text('descripcion');
            $table->foreignId('usuario_id')->constrained('usuarios')->restrictOnDelete();
            $table->date('fecha_registro');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios_resultado');
    }
};
