<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos_sustento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('costo_real_id')->constrained('costos_reales')->cascadeOnDelete();
            $table->string('nombre_archivo', 180);
            $table->string('ruta_archivo', 255);
            $table->date('fecha_carga');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_sustento');
    }
};
