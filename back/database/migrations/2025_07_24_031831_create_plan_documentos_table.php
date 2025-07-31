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
        Schema::create('plan_documentos', function (Blueprint $table) {

            $table->id();


            $table->foreignId('plan_de_desarrollo_id')
                ->constrained('plan_de_desarrollos')
                ->cascadeOnDelete();

            $table->string('path');
            $table->string('nombre');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_documentos');
    }
};
