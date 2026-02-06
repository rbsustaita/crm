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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('trade_name');
            $table->string('tax_id')->unique();
            $table->string('tipo_persona');
            $table->string('sector');
            $table->string('sub_category');
            $table->string('website')->nullable();            
            $table->foreignId('address_id')->nullable()/* ->constrained('addresses')->onDelete('set null') */;
            $table->boolean('active')->default(false);
/*             $table->foreignId('person_id')->default(1)->constrained('people')->onDelete('set null'); */
            $table->foreignId('person_id')->nullable();
            $table->foreignId('user_id')->default(1)/* ->constrained('users')->onDelete('set null') */;
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
