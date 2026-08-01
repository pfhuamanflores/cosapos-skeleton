<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consolidado_resultado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consolidado_corporativo_id')->constrained('consolidados_corporativos')->cascadeOnDelete();
            $table->foreignId('resultado_operativo_mensual_id')->constrained('resultados_operativos_mensuales')->cascadeOnDelete();
            $table->unique(['consolidado_corporativo_id', 'resultado_operativo_mensual_id'], 'consolidado_resultado_unique');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consolidado_resultado');
    }
};
