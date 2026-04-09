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
        Schema::create('contractforms', function (Blueprint $table) {
            $table->id();
            $table->string('contract_type');
            $table->string('identifier')->unique();
            $table->integer('review')->unique();
            $table->date('effective_date');
            $table->json('ui_statements');
/*             $table->json('client_statements'); */
            $table->json('clauses');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractforms');
    }
};
