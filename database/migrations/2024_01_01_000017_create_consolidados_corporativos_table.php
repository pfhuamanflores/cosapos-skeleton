<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consolidados_corporativos', function (Blueprint $table) {
            $table->id();
            $table->string('periodo', 7)->unique();
            $table->decimal('venta_total', 16, 2)->default(0);
            $table->decimal('utilidad_total', 16, 2)->default(0);
            $table->decimal('margen_corporativo', 6, 3)->default(0);
            $table->foreignId('generado_por')->constrained('usuarios')->restrictOnDelete();
            $table->dateTime('fecha_generacion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consolidados_corporativos');
    }
};
