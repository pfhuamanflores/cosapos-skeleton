<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultados_operativos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->unique()->constrained('proyectos')->cascadeOnDelete();
            $table->decimal('venta', 14, 2);
            $table->decimal('costo_total', 14, 2);
            $table->decimal('utilidad', 14, 2);
            $table->decimal('margen', 6, 3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultados_operativos');
    }
};
