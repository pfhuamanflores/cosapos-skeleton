<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partidas_presupuestales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_base_id')->constrained('presupuestos_base')->cascadeOnDelete();
            $table->foreignId('plan_fase_id')->nullable()->constrained('plan_fases')->nullOnDelete();
            $table->string('codigo', 30);
            $table->string('nombre', 150);
            $table->string('categoria_costo', 80)->nullable();
            $table->decimal('monto_presupuestado', 14, 2)->default(0);
            $table->enum('tipo', ['Normal', 'Extraordinaria'])->default('Normal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidas_presupuestales');
    }
};
