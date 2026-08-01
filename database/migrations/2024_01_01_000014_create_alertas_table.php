<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resultado_operativo_mensual_id')->constrained('resultados_operativos_mensuales')->cascadeOnDelete();
            $table->string('tipo', 60)->default('Desviacion de rentabilidad');
            $table->string('mensaje', 255);
            $table->string('nivel', 20)->default('Alta');
            $table->date('fecha');
            $table->enum('estado', ['Activa', 'Atendida'])->default('Activa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
