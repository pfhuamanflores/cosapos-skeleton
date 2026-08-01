<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 150);
            $table->string('cliente', 150);
            $table->string('ubicacion', 150)->nullable();
            $table->string('tipo_contrato', 60)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_termino')->nullable();
            $table->string('tipo_moneda', 10)->default('PEN');
            $table->string('unidad_negocio', 100)->nullable();
            $table->foreignId('creado_por')->constrained('usuarios')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
