<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_recursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_fase_id')->constrained('plan_fases')->cascadeOnDelete();
            $table->string('descripcion', 255);
            $table->decimal('cantidad', 10, 2);
            $table->string('unidad_medida', 30)->nullable();
            $table->date('fecha_requerida');
            $table->enum('estado', ['Pendiente', 'Aprobada', 'Observada', 'Rechazada'])->default('Pendiente');
            $table->foreignId('solicitante_id')->constrained('usuarios')->restrictOnDelete();
            $table->foreignId('responsable_resolucion_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->date('fecha_resolucion')->nullable();
            $table->string('observacion', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_recursos');
    }
};
