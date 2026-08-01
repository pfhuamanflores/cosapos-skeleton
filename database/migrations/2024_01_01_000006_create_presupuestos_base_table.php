<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presupuestos_base', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->unique()->constrained('proyectos')->cascadeOnDelete();
            $table->string('codigo', 30)->unique();
            $table->string('descripcion', 255)->nullable();
            $table->decimal('monto_total_presupuestado', 14, 2)->default(0);
            $table->date('fecha_aprobacion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presupuestos_base');
    }
};
