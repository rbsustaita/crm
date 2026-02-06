<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_solicitud', 50);
            $table->foreignId('client_id')/* ->constrained('people')->onDelete('cascade') */;
            $table->date('fecha_solicitud', now());
            $table->string('norma_aplicable', 100);
            $table->string('servicio_solicitado', 100)->unique();
            $table->string('direccion_fiscal', 300);
                        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
