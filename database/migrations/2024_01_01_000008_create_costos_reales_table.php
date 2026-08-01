<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costos_reales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partida_presupuestal_id')->constrained('partidas_presupuestales')->cascadeOnDelete();
            $table->decimal('monto_neto', 14, 2);
            $table->date('fecha_registro');
            $table->string('tipo_moneda', 10)->default('PEN');
            $table->decimal('tipo_cambio', 8, 4)->default(1);
            $table->foreignId('registrado_por')->constrained('usuarios')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costos_reales');
    }
};
