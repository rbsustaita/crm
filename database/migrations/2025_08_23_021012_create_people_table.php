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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name')->label('Nombre')->required();
            $table->string('middle_name')->label('Apellido Paterno')->required();
            $table->string('last_name')->label('Apellido Materno')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('rfc')->nullable();
/*             $table->string('tipo_persona')->nullable(); */
/*             $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade'); */
            $table->morphs('personable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
