<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas_contractuales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->unique()->constrained('proyectos')->cascadeOnDelete();
            $table->decimal('monto_contrato', 14, 2);
            $table->date('fecha_firma');
            $table->string('estado_contrato', 40)->default('Vigente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas_contractuales');
    }
};
