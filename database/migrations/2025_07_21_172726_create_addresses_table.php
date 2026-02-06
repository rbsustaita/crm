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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()/* ->constrained()->onDelete('cascade') */;
            $table->string('tipo_de_domicilio', 50)->nullable();
            $table->string('tipo_vialidad', 25)->searchable()->nullable();
            $table->string('nombre_vialidad', 100)->nullable();
            $table->string('numero_exterior', 10)->nullable();
            $table->string('numero_interior', 10)->nullable();
            $table->string('colonia', 100)->nullable();
            $table->string('municipio', 50)->nullable();
            $table->string('entidad', 50)->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->string('pais_nombre', 50)->nullable();
            $table->string('referencias', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
